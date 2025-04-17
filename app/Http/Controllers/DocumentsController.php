<?php

namespace App\Http\Controllers;

use App\Http\Requests\Document\DocumentCreateRequest;
use App\Http\Requests\Document\DocumentDeleteRequest;
use App\Http\Requests\Document\DocumentDownloadRequest;
use App\Http\Requests\Document\DocumentIndexRequest;
use App\Http\Requests\Document\DocumentUpdateRequest;
use App\Http\Requests\Document\DocumentUploadRequest;
use App\Http\Requests\Document\DocumentViewRequest;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use App\Notifications\DocumentUploaded;
use Carbon\Carbon;
use Exception;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-document', ['only' => ['create', 'store']]);
        // $this->middleware('permission:view-document', ['only' => ['view', 'index']]);
        $this->middleware('permission:update-document', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-document', ['only' => ['destroy', 'destroyBulk', 'forceDelete']]);
    }

    /**
     * Display the specified resource.
     */
    public function view(DocumentViewRequest $request)
    {
        $document = Document::findOrFail($request->document);

        activity()
            ->causedBy(auth()->id())
            ->event('viewed')
            ->performedOn($document)
            ->log('viewed');

        return response()->fileFromStorage('do', $document);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(DocumentIndexRequest $request, $user)
    {
        $user = User::findOrFail($user)->load('company:id,name');

        $category_id = (int) implode($request->only('category')) ?? 1;

        $category = Category::findOrFail($category_id);

        $years = Document::select([DB::raw('year(date) year')])
            ->whereNotNull('date')
            ->distinct()
            ->orderBy('date', 'desc')
            ->pluck('year')
            ->toArray();

        $selectedYear = (int) implode($request->only('selectedYear')); // array

        if (! $selectedYear) {
            $selectedYear = $years[0];
        }

        $startOfYear = Carbon::createFromFormat('Y', $selectedYear)->startOfYear();
        $endOfYear   = Carbon::createFromFormat('Y', $selectedYear)->endOfYear();

        $documents = Document::with('category:id,name')
            ->where('user_id', $user->id)
            ->where('category_id', $category_id)
            ->whereBetween('date', [$startOfYear, $endOfYear])
            ->latest();

        $categories = Category::withCount(['documents' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->get('id', 'name');

        return Inertia::render('Documents/Index', [
            'title'             => __('app.label.profile').' / '.__('app.label.documents'),
            'categories'        => $categories,
            'category'          => $category_id,
            'documents'         => $documents->paginate(25),
            'user'              => $user,
            'years'             => $years,
            'selectedYear'      => $selectedYear,
            'breadcrumbs'       => [
                                    ['label' => __('app.label.profile'), 'href' => route('users.show', [$user->id])],
                                    ['label' => __('app.label.documents'), 'href' => route('documents.index', [$user->id, 'category' => $category->id, 'selectedYear' => $selectedYear])],
                                    ['label' => $category->name, 'href' => '#'],
                                    ]
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(DocumentCreateRequest $request): Response
    {
        return Inertia::render('Documents/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DocumentUploadRequest $request, User $user)
    {
        DB::beginTransaction();
        try {
            if ($request->hasFile('file')) {
                try {

                    $disk = Storage::disk('do');

                    $path = 'documents/'.$user->id;

                    $file = $request->file('file');

                    $uuid = Str::uuid()->toString();

                    $alias =  $uuid . '.' . $file->getClientOriginalExtension();

                    $file = $disk->putFileAs($path, $file, $alias);

                    $document = new Document();
                    $document->category_id = $request->category;
                    $document->disk = 'do';
                    $document->file = $path . '/' . $alias;
                    $document->user_id = $user->id;
                    $document->alias = $request->alias;
                    $document->extension = Str::lower($request->file('file')->getClientOriginalExtension());
                    $document->mime = $request->file('file')->getMimeType();
                    $document->size = $request->file('file')->getSize();
                    $document->date = Carbon::createFromDate($request->date)->timezone('Europe/Istanbul')->toDateString();

                    $document->description = $request->description;
                    $document->save();

                } catch (Exception $exception) {
                    return response()->json(['message' => $exception->getMessage()], 409);
                }
            }

            DB::commit();
            // if ($document->category_id == 1) {
            //     $user->notify((new DocumentUploaded($user, $document->category_id)));

            activity()
            ->causedBy(auth()->id())
            ->performedOn($user)
            ->log('mailed');


            // }
            return back()->with('success', __('app.label.uploaded_successfully', ['name' => 'Dosya']));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.uploaded_error', ['name' => __('app.label.document')]) . $th->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(DocumentUpdateRequest $request, Document $document)
    {
        DB::beginTransaction();
        try {
            $document->update([
                'alias'         => $request->alias,
                'category_id'   => $request->category,
                'date'          => Carbon::createFromDate($request->date)->timezone('Europe/Istanbul')->toDateString(),
                'description'   => $request->description,
            ]);
            DB::commit();
            return back()->with('success', __('app.label.updated_successfully', ['name' => $document->name]));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.updated_error', ['name' => $document->name]) . $th->getMessage());
        }
    }

    /**
     * Download the specified resource.
     */
    public function download(DocumentDownloadRequest $request, User $user, Document $document)   //download
    {
        $disk = Storage::disk('do');

        $file = $disk->get($document->file);

        activity()
            ->causedBy(auth()->id())
            ->performedOn($document)
            ->log('downloaded');

        return response($file, 200, [
            'Content-Type'              => $document->mime,
            'Content-Description'       => 'File Transfer',
            'Content-Disposition'       => "attachment; filename={$document->alias}.{$document->extension}",
            'Content-Transfer-Encoding' => 'binary',
        ]);
    }


    /**
     * Delete the specified resource
     */
    public function destroy(DocumentDeleteRequest $request, $doc_id): RedirectResponse
    {
        $document = Document::findorFail($doc_id);

        $disk = Storage::disk('do');

        try {
            $disk->delete($document->file);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 409);
        }

        $document->delete();

        return back()->with('success', 'Doküman başarıyla silindi');

    }
}
