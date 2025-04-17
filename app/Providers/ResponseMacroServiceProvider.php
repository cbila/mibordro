<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('fileFromStorage', function ($disk, $document) {

            try {
                $temp_filepath = tempnam(sys_get_temp_dir(), '');

                $file_data = Storage::disk($disk)->get($document->file);

                if(! $file_data){
                    return redirect()->back()->with('error', __('app.label.created_error', ['name' => 'Dosya Bulunamadı']) . $th->getMessage());
                } 
                
                file_put_contents($temp_filepath, $file_data); 

                return response()
                ->download($temp_filepath, $document->alias.'.'.$document->extension, [], 'inline')
                ->deleteFileAfterSend();

            } catch (\Throwable $th) {
                return redirect()->back()->with('error', __('app.label.created_error', ['name' => 'Dosya Bulunamadı']) . $th->getMessage());
            }    
        });
    }
}
