<template>
  <div>
    <vue-dropzone
      ref="productDropzone"
      :options="dropzoneOptions"
      :include-styling="false"
      @vdropzone-thumbnail="thumbnail"
      @vdropzone-success="showSuccess"
      @vdropzone-error="showError"
      @vdropzone-removed-file="fileRemoved"
      @vdropzone-sending="vsending"
      :useCustomSlot=true
      id="customdropzone"
      :destroyDropzone="false">
      <!--<div class="dropzone-custom-content">
        <v-container v-if="colFiles == 0" fill-height>
          <v-alert  border="bottom" dense text>
            Область для загрузки!
          </v-alert>
        </v-container>
      </div>-->
    </vue-dropzone>
  </div>
</template>

<script>
  import vueDropzone from 'vue2-dropzone'
  import { mapActions, mapState } from 'vuex'
  import { GLOBAL } from '@/constants'

  export default {
    name: 'File-Box',
    props: {
      'url': {
        type: String,
        default: '/files/upload'
      },
      'fileableId': {
        type: Number,
        required: true
      },
      'typeFiles' :  {
        type: Array,
        required: true
      },
      'model': {
        type: String,
        required: true
      }
    },
    data() {
      return {
        dropzoneOptions: {
          dictDefaultMessage: '<br>Переместите файлы для загрузки ',
          url: this.url,
          thumbnailWidth: 150,
          previewTemplate: this.template(),
          addRemoveLinks: true,
          headers: { 'X-CSRF-TOKEN': window.token },
          maxFiles: 30,
        },
        errorMessage: '',
        colFiles: 0
      }
    },
    computed: {
      ...mapState('files', { files: 'items' })
    },
    components: {
      vueDropzone
    },
    watch: {
      fileableId: {
        deep: true,
        handler(val) {
          this.fileHandler()
        }
      },
      files: {
        deep: true,
        handler(val) {
          this.fileHandler()
        }
      }
    },
    beforeRouteEnter(to, from, next) {
      next(vm => vm.load())
    },
    beforeRouteUpdate(to, from ,next) {
      this.load()
      next()
    },
    mounted() {
      this.fileHandler()
    },
    methods: {
      ...mapActions('initializer', ['handleError']),
      ...mapActions('files', {'loadByKey': GLOBAL.LOAD_BY_KEY}),
      template() {
        return `
                    <div class="dz-preview dz-file-preview" id="drop-img-vue">
                        <div class="dz-image">
                            <div data-dz-thumbnail-bg></div>
                        </div>
                        <div class="dz-details">
                            <div class="dz-size"><span data-dz-size></span></div>
                            <div class="dz-filename"><span data-dz-name></span></div>
                        </div>
                        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                        <div class="dz-error-message"><span data-dz-errormessage></span></div>
                        <div class="dz-success-mark"><i class="fa fa-check"></i></div>
                        <div class="dz-error-mark"><i class="fa fa-close"></i></div>
                        <a class="dz-remove ms" href="javascript:undefined;" data-dz-remove="">Удалить</a>
                    </div>
            `;
      },
      fileHandler() {
        $('.dz-preview').remove();
        let dropzone = this.$refs.productDropzone
        let files = this.files.filter(file =>  file.fileable_id == this.fileableId && file.fileable_type == this.model)
        if (files.length > 0) {
          $(".dz-message").hide();
        } else {
          $(".dz-message").show();
        }
        files.forEach(item => {
          if(item.config.files["small"]) {
            let id = item.id;
            let filename = item.config.files["small"].filename;
            let size = item.config.files["small"].size;
            let mockFile = {id: id ,name: filename.slice(0,19), size: size, type: "image/png"};
            let url = '/storage/'+filename
            dropzone.manuallyAddFile(mockFile,"/storage/"+filename,null,null,{dontSubstractMaxFiles: false, addToFiles: true});
            this.colFiles = this.colFiles+1;
          }
        });
      },
      thumbnail: function(file, dataUrl) {
        var j, len, ref, thumbnailElement;
        if (file.previewElement) {
          file.previewElement.classList.remove("dz-file-preview");
          ref = file.previewElement.querySelectorAll("[data-dz-thumbnail-bg]");
          for (j = 0, len = ref.length; j < len; j++) {
            thumbnailElement = ref[j];
            thumbnailElement.alt = file.name;
            thumbnailElement.style.backgroundImage = 'url("' + dataUrl + '")';
          }
          return setTimeout(((function(_this) {
            return function() {
              return file.previewElement.classList.add("dz-image-preview");
            };
          })(this)), 1);
        }
      },
      vsending(file, xhr, formData) {
        // нужно будет потом закоментировать и проверить обработку ошибок!
        formData.append('fileable_id',this.fileableId);
        formData.append('name_type_file', this.typeFiles[0]);
        formData.append('fileable_type', this.model);
      },
      showSuccess(file,data) {
        this.$store.dispatch('files/set', {items: data}, {root: true})
      },
      showError(file, message, xhr) {
        let response = xhr.response;
        this.handleError(xhr);
        /*let parse = JSON.parse(response, (key, value)=>{
          return value;
        });
        $('.dz-error-message span').text(parse.message);*/
      },
      fileRemoved(file)  {
        let id = file.xhr?JSON.parse(file.xhr.response).id:file.id;
        axios.get('/files/delete-file/'+id)
      }
    }
  }
</script>
<style>
  #customdropzone {
    border: 5px solid #fff;
    font-family: 'Arial', sans-serif;
    letter-spacing: 0.2px;
    color: #777;
    transition: background-color .2s linear;
    height: 250px;
    padding: 40px;
    overflow-x: scroll;
  }
  #customdropzone .dz-preview {
    width: 200px;
    display: inline-block
  }
  #customdropzone .dz-preview .dz-image {
    width: 100px;
    height: 100px;
    margin-left: 40px;
    margin-bottom: 10px;
  }
  #customdropzone .dz-preview .dz-image > div {
    width: inherit;
    height: inherit;
    border-radius: 50%;
    background-size: 100px 100px;
  }

  #customdropzone .dz-preview .dz-image > img {
    width: 100%;
  }
  #customdropzone .dz-preview .dz-details {
    color: white;
    transition: opacity .2s linear;
    text-align: center;
  }
  #customdropzone .dz-success-mark, .dz-error-mark, .dz-remove {
    display: none;
  }
  #customdropzone .dz-error-message {
    color: red;
  }
  #customdropzone .dz-preview .dz-remove {
    color: white;
  }
  #customdropzone .dz-message {
  }
  .dropzone-custom-title {
    color: #fff;
    text-transform: uppercase;
  }
  .ms {
    display: block;
    text-align: center;
    text-decoration: none;
  }
</style>
