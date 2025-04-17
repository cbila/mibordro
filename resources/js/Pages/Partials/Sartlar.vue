<script setup>
import Modal from "@/Components/Modal.vue";

const emit = defineEmits(["close"]);

const props = defineProps({
    show: Boolean,

});


</script>


<template>
    <section class="space-y-6">
        <Modal :show="props.show" @close="emit('close')">
            <div class="p-6">
                <p><strong>KULLANIM KOŞULLARI ve GİZLİLİK</strong></p>

                <p>Metropol International İnsan Kaynakları bu b&ouml;l&uuml;mde belirtilen politikalar ve prosed&uuml;rler ile uyumlu olarak vereceğiniz kişisel bilgileri toplar, kullanır. Web sayfamıza erişerek ve Metropol International&rsquo;ın sistemine &ouml;zge&ccedil;mişinizi veya bilgilerinizi kaydederek, Metropol International&rsquo;ın, H&uuml;k&uuml;mler, Koşullar ve Gizlilik Politikasında belirtildiği şekilde kişisel bilgi toplamasına ve işlemesine onay verirsiniz.</p>

<p>Sayfamızdaki &ldquo;genel başvuru&rdquo; alanına yapmış olduğunuz başvuru, &ouml;zge&ccedil;mişinizi kayıt bilgilerinizle birlikte Metropol International&rsquo;ın &ouml;zge&ccedil;miş veritabanına kaydetmenize olanak verir. &Ouml;zge&ccedil;mişiniz, Metropol International&rsquo;ın &ouml;zel geliştirdiği yazılım sisteminde saklanır ve bu sisteme Metropol International&rsquo;ın dışında erişim bulunmamaktadır.</p>

<p>( &Ouml;zet CV Hari&ccedil; ) Gizliliğin korunması ve sisteme dışarıdan erişimin engellenmesi i&ccedil;in en &uuml;st seviye g&uuml;venlik yazılımları ve sistemleri kullanılmaktadır. Yine de Metropol International, kendisine g&ouml;nderilen veya sizin bilgisayar sisteminizde tutulan kişisel bilgilere erişen yetkisiz &uuml;&ccedil;&uuml;nc&uuml; taraflara karşı bir sorumluluk veya y&uuml;k&uuml;ml&uuml;l&uuml;k kabul etmez.</p>

<p>Metropol International, &ouml;zge&ccedil;mişinizi olası daimi ve d&ouml;nemsel a&ccedil;ık işler i&ccedil;in değerlendirmeye alır ve bu doğrultuda size iş fırsatları sunabilir. &Ouml;zge&ccedil;mişinizi aldıktan sonra, sistemde sizinle ilgili bir kayıt yaratmak i&ccedil;in &ouml;zge&ccedil;mişinizdeki bilgilerden yararlanır. Sizden doğrudan alınan yazılı bilgileri, &ouml;zge&ccedil;mişinizden alınan bilgiye ekleyebilir. Metropol International&rsquo;ın yazılım sisteminde yer alan kaydınıza eklenebilecek bilgiler, sizin işe alınma s&uuml;recinizde gerekli veya yardımcı olacağı d&uuml;ş&uuml;n&uuml;len ve yardımcı olmak amacını taşıyan bilgilerdir.</p>

<p>Metropol International, sizin beceri ve deneyiminizin bir profilini, Metropol International tarafından se&ccedil;ilen T&uuml;rkiye i&ccedil;i veya dışındaki kuruluşlara g&ouml;nderebilir. T&uuml;m bu işlemler sırasında bilgi gizliliğini korumaya &ouml;zen g&ouml;sterir. Profiliniz, &ouml;zge&ccedil;mişiniz ve yazılı veya s&ouml;zl&uuml; olarak vermiş olduğunuz bilgilerden derlenir.</p>

<p>Paylaştığınız ve veya Metropol International İnsan Kaynakları&rsquo;nın başka CV portalları &uuml;zerindeki ilanlarına yapmış olduğunuz başvurularınızdaki CV i&ccedil;eriğinde bulunan referans bilgilerinizin Metropol tarafından istendiği zaman aranılmasına izin vermiş olursunuz.</p>

<p>Eğer Metropol International&rsquo;ın profilinizi olası işverenlere g&ouml;ndermesini istemiyorsanız&nbsp;<u>mi@mi.com.tr&nbsp;</u>adresine &ldquo;CV Sil&rdquo; başlıklı elektronik posta g&ouml;ndermenizi rica ederiz.</p>

 
            </div>
        </Modal>
    </section>
</template>