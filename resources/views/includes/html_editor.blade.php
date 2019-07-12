
@php ($id = htmlId())
<textarea 
    id="{{ $id }}"
    @isset($name)
    name="{{ $name }}"
    @endif
    class="{{ $class ?? 'form-control' }}">{{ $value ?? '' }}</textarea>

@push('scripts')

<script src="//cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
$(document).ready(function(){
    tinymce.init({
        selector: '#{{ $id }}',
        plugins: [
            "advcode", 
            "codesample", 
            "fullscreen", 
            "autoresize", 
            "searchreplace", 
            "table", 
            "preview", 
            "image",
            "imagetools",
            "media",
            "mediaembed",
            "anchor",
            "casechange",
            "emoticons",
            "help",
            "link",
            
        ],
        
        autoresize_bottom_margin: 25,
        codesample_languages: [
            {text: 'HTML/XML', value: 'markup'},
            {text: 'JavaScript', value: 'javascript'},
            {text: 'CSS', value: 'css'},
            {text: 'PHP', value: 'php'},
            {text: 'Bash', value: 'bash'},
            {text: 'Twig', value: 'twig'},
        ],
        min_height : 300,
        images_upload_url: '{{ adminUrl("/images") }}',
        image_uploadtab: true,
        automatic_uploads: true,
        images_upload_handler: function (blobInfo, success, failure) {
           var xhr, formData;
           xhr = new XMLHttpRequest();
           xhr.withCredentials = false;
           xhr.open('POST', '{{ adminUrl("/images") }}');
           var token = '{{ csrf_token() }}';
           xhr.setRequestHeader("X-CSRF-Token", token);
           xhr.onload = function() {
               var json;
               if (xhr.status != 200) {
                   failure('HTTP Error: ' + xhr.status);
                   return;
               }
               json = JSON.parse(xhr.responseText);

               if (!json || typeof json.location != 'string') {
                   failure('Invalid JSON: ' + xhr.responseText);
                   return;
               }
               success(json.location);
           };
           formData = new FormData();
           formData.append('image', blobInfo.blob(), blobInfo.filename());
           xhr.send(formData);
        },
        file_picker_types: 'image',
        /* and here's our custom image picker*/
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            /*
            Note: In modern browsers input[type="file"] is functional without
            even adding it to the DOM, but that might not be the case in some older
            or quirky browsers like IE, so you might want to add it to the DOM
            just in case, and visually hide it. And do not forget do remove it
            once you do not need it anymore.
            */

            input.onchange = function () {
            var file = this.files[0];

            var reader = new FileReader();
            reader.onload = function () {
                /*
                Note: Now we need to register the blob in TinyMCEs image blob
                registry. In the next release this part hopefully won't be
                necessary, as we are looking to handle it internally.
                */
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);

                /* call the callback and populate the Title field with the file name */
                cb(blobInfo.blobUri(), { title: file.name });
            };
            reader.readAsDataURL(file);
            };

            input.click();
        }
    });
});
</script>
@endpush