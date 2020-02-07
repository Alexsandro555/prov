<template>
  <v-card  light>
    <div :id="'editor-'+id"></div>
  </v-card>
</template>
<script>
  import vueditor from './vueditor/dist/script/vueditor.min.js'
  import './vueditor/dist/style/vueditor.min.css'
  import { lang } from './vueditor/dist/language/lang.ru.js'
  import { ACTIONS, GLOBAL } from '@/constants'

  export default {
    data() {
      return {
        inst: null,
        lang: lang
      }
    },
    props: {
      'id': {
        type: Number,
        required: true
      },
      'model': {
        type: String,
        required: true
      },
      'url': {
        type: String,
        default: 'files'
      },
      'typeFile': {
        type: String,
        default: 'file'
      },
      'typeImage': {
        type: String,
        default: 'image-wysiwyg'
      },
      'value': {
        type: String
      }
    },
    computed: {
      descVal() {
        return this.inst?this.inst.getContent():'';
      }
    },
    watch: {
      descVal(val) {
        this.$emit('input',val);
      },
      value(val) {
        this.inst.setContent(val);
      }
    },
    mounted() {
      this.inst = vueditor.createEditor('#editor-'+this.id, {
        url: this.url,
        fileable_id: this.id,
        name_type_file: this.typeImage,
        fileable_type: this.model,
        id: 'product-wysiwyg',
        classList: ['product-wysiwyg'],
        lang: {
          app: {},

          removeFormat: {title: 'Убрать форматирование'},

          bold: {title: 'Жирный'},
          italic: {title: 'Курсив'},
          underline: {title: 'Подчеркнутый'},
          strikeThrough: {title: 'Перечеркнутый'},

          superscript: {title: 'Верхний индекс'},
          subscript: {title: 'Нижний индекс'},
          indent: {title: 'Отступ'},
          outdent: {title: 'Выступ'},

          justifyLeft: {title: 'По левому краю'},
          justifyCenter: {title: 'По центру'},
          justifyRight: {title: 'По правому краю'},
          justifyFull: {title: 'На всю ширину'},

          insertOrderedList: {title: 'Вставить нумерованный список'},
          insertUnorderedList: {title: 'Вставить ненумерованный список'},

          foreColor: {
            title: 'Цвет шрифта',
            ok: 'ok',
            colorCode: 'Цветовой режим',
            invalidColorCodeMsg: 'Пожалуйста введите корректный цветовой код',
          },
          backColor: {
            title: 'Цвет фона',
            ok: 'ok',
            colorCode: 'Цветовой режим',
            invalidColorCodeMsg: 'Пожалуйста введите корректный цветовой код',
          },

          fontName: {},
          fontSize: {},
          code: {},
          element: {},

          design: {
            ieMsg: 'Вы должны выбрать текст, чтобы использовать эту функцию в браузере IE'
          },
          link: {
            title: 'Добавить ссылку',
            ok: 'OK'
          },
          unLink: {
            title: 'Убрать ссылку'
          },
          markdown: {
            title: 'markdown'
          },
          picture: {
            title: 'Загрузка изображений',
            ok: 'OK',
            cancel: 'Отмена',
            invalidFile: 'Выбранный файл не является изображением',
          },
          pdf: {
            title: 'Загрузка документации в формате pdf',
            ok: 'OK',
            cancel: 'Отмена',
          },
          sourceCode: {
            title: 'Исходный код'
          },
          fullscreen: {
            title: 'полный экран'
          },
          table: {title: 'Таблица'},
          undo: {title: 'Назадо'},
          redo: {title: 'Вперед'}
        }
      });
      this.inst.setContent(this.value)
    }
  }
</script>

<style>
  .product-wysiwyg {
    min-height: 350px;
  }
</style>