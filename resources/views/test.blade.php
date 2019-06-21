@include("MainParts.header")

<button id="file">Teszt fájl</button>
<input type="text" id="file_url">
<img src="" alt="" id="kep">
<script>

var button_file = document.getElementById('file');

button_file.addEventListener("click",function(){

selectFileWithCKFinder('file_url');

});


function selectFileWithCKFinder(elementId){
    CKFinder.modal({
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function(finder){
            finder.on('files:choose', function(evt){
                var file = evt.data.files.first();
                var output = document.getElementById(elementId);
                output.value = file.getUrl();
                document.getElementById("kep").src = output.value;
            });
            finder.on('file:choose:resizedImage', function(evt){
                var output = document.getElementById(elementId);
                
                output.value = evt.data.resizedUrl;
                document.getElementById("kep").src = output.value;
            });
        }
    });
}

</script>

          @include("MainParts.footer")