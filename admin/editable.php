<?php
   require_once __DIR__."/../modules/sql_connect.php";
   require_once __DIR__."/../modules/App.php";
   require_once __DIR__."/../modules/TinyLink.php";
   require_once __DIR__."/modules/Auth.php";
   
   if ( !$auth -> checkLogin() )
      header("Location: login?goto=https".$_SERVER["HTTP_HOST"]."/".$_SERVER["REQUEST_URI"]);
   if ( isset($_POST["submit"]) || (isset($_POST["ajax"]) && $_POST["ajax"]) ) {
      $vers = [];
      if ( isset($_POST["versions"]) && isset($_POST["urls"]) ) {
         foreach ( $_POST["versions"] as $index => $value ) {
            $vers[$value] = $TinyLink -> createHash($_POST["urls"][$index]);
         };
      };
      
      $args = (object) [];
      foreach ( ["name", "author", "account", "description", "category"] as $key ) {
         if ( isset($_POST[$key]) ) {
            $args -> $key = $_POST[$key];
         };
      };
      $args -> icon = $_FILES["icon"];
      $args -> versions = $vers;
      $args -> supports = explode(" ", $_POST["supports"]);
      
      if ( isset($_POST["replace"]) )
         $args -> replace = $_POST["replace"];
      else $args -> replace = true;
      
      $res = $App -> add($args);
      
      if ( isset($_POST["ajax"]) && $_POST["ajax"] ) {
          echo json_encode([
              "error" => $sql -> error,
              "exists" => $res
          ]);
          die();
      } else {
          $mess = $sql -> error;
      }
   };
   
   if ( isset($_GET["name"]) && !!$_GET["name"] ) {
		$name = str_replace("-", " ", str_replace(" ", "+", $_GET["name"]));
		
		$result = $sql -> query("select * from Apps where name='$name'");
		//echo $sql -> error;
		
		if ( $result -> num_rows > 0 ) {
			$tmp = $result -> fetch_array();

			$versions = unserialize($tmp["versions"]);
            $arrayVersions = [];
            
			foreach ( $versions as $key => $value ) {
				array_push($arrayVersions, [$key, $TinyLink -> findLink($value)]);
			}
			
			$app["versions"] = $arrayVersions;
		
	    	$app["supports"] = unserialize($tmp["supports"]);
		    $app["images"] = "/upload/".urlencode(urlencode($tmp["name"])).".png";
		    foreach ( ["name", "author", "description", "category", "account", "id"] as $val )
		        $app[$val] = stripslashes ($tmp[$val]);
		}
		
		$result -> free_result();

	}
	
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Page Title</title>
        <script src="https://nguyenthanh1995.github.io/lib/vue.development.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://unpkg.com/easymde@2.11.0/dist/easymde.min.css">
        <script src="https://unpkg.com/easymde@2.11.0/dist/easymde.min.js"></script>
        <script src="https://nguyenthanh1995.github.io/my-new.js"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.0/dist/sweetalert2.min.css">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.0/dist/sweetalert2.min.js"></script>
		<link rel="stylesheet" href="https://nguyenthanh1995.github.io/lib/awesome pro/css/all.min.css">
    </head>
    <body>
        <form method="post" action="" id="app" enctype="multipart/form-data" @input="stateAlertStatus = false" @submit.prevent="submit">
            <div class="header d-flex align-items-center">
                <div class="header__avatar">
                    <img class="header__avatar--icon bg-muted rounded border" :src="app.images" @click="$refs.File.click()">
                    <input hidden type="file" name="icon" @change="updateIcon" ref="File">
                </div>
                
                <div class="header__name-author">
                    <input class="no-input app-title" placeholder="App name" name="name" required v-model="app.name">
                    <br>
                    <input class="no-input dev-dev" placeholder="Developer" name="author" required v-model="app.author">
                </div>
            </div>
            
            <div class="main mt-3">
                <div class="container-fluid bg-white py-3">
                    <?
                       if ( isset($mess) ) {
                           echo '<div class="col-12" v-if="stateAlertStatus"> <div class="alert alert-'.(!!$mess ? "danger" : "success").'">';
                           echo !!$mess ? $mess : "Tải lên thành công";
                           echo "</div></div>";
                       }
             
              if ( isset($app) )
                    echo '<div class="col-12 text-secondary">
                        <i class="fad fa-pencil"></i> Chế độ chỉnh sửa ứng dụng "'.$app["name"].'"
                    </div>';
                    ?>
                    
                    <div class="form-group col-12 col-md-6 order-md-0">
                        <label>Tài khoản kích hoạt</label>
                        <input class="form-control" placeholder="example@icloud.com" name="account" v-model="app.account">
                        <small class="text-secondary"> Nếu đây là iPA bỏ trống trường này </small>
                    </div>
                    
                    <div class="form-group col-12">
                        <div class="form-group--title">
                            Versions
                            <span class="float-right" @click="app.versions.push([])"> + </span>
                        </div>
                        <div class="versions_item">
                            <div class="input-group my-2" v-for="(item, index) in app.versions">
                                <input class="form-control" placeholder="Verions" name="versions[]" required v-model="item[0]">
                
                 <input class="form-control" placeholder="URL" name="urls[]" required v-model="item[1]"> 
                 
                 <div class="input-group-append">
                     <span class="input-group-text bg-0" @click="app.versions.splice(index, 1)"> &times; </span>
                 </div>
              </div>
                            
                            <div v-if="!app.versions || !app.versions.length" class="text-center py-3 text-secondary border border-top-0" @click="app.versions.push([])">
                                Tap to + 
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group col-12 col-md-6 order-md-1">
                        <div class="form-group--title">
                            Category
                        </div>
                        <select class="form-control custom-select" name="category" v-model="app.category">
                            <option value="ipa" selected :disabled="!!app.account">iPA</option>
                            <option value="apps" :disabled="!app.account">Apps</option>
                            <option value="games" :disabled="!app.account">Games</option>
                           <option value="jailbreak" :disabled="!app.account"> Jailbreak </option>
                        </select>
                    </div>

                    <div class="form-group col-12 col-md-6 order-md-2">
                        <div class="form-group--title">
                            Support
                        </div>
                        <input placeholder="Input iOS app support" class="form-control" name="supports" required :value="app.supports.join(' ')" @input="app.supports = $event.target.value.split(' ')">
                    </div>

                    <div class="form-group col-12">
                        <div class="form-group--title">
                            Description
                        </div>
                        <textarea class="form-control" id="description" name="description" ref="Textarea" v-model="app.description"></textarea>
                    </div>
                    
                    <div class="form-group col-12">
                        <button name="submit" type="submit" class="btn btn-primary btn-block"> <?= isset($app) ? "Cập nhật" : "Tải lên" ?> </button>
                    </div>
                </div>
            </div>
        </form>
    <script>onerror = console.error = console.warn = (...args) => alert(args.join("\n"))</script>
<script>
var app = new Vue({
    el: "#app",
    data: {
        MDE: null,
        app: <?= isset($app) ? json_encode($app) : '{
            images: "https://upload.wikimedia.org/wikipedia/commons/0/06/OOjs_UI_icon_add.svg",
            name: "",
            author: "",
            account: "",
            versions: [],
            supports: [],
            description: ""
        }' ?>,
        stateAlertStatus: true,
    },
    methods: {
        updateIcon(e) {
            let file = e.target.files[0]

             let fileReader = new FileReader

             fileReader.onload = () => {
                 this.$set(this.app, "images", fileReader.result)
             };
             fileReader.readAsDataURL(file)
        },
        submit(e, replace) {
           this.app.description = this.MDE.getValue()
           replace |= <?= isset($app) ? "true" : "false" ?>;
           
           let formData = new FormData(e.target)
           formData.append("ajax", true)
           
           if ( replace ) {
              formData.append("replace", true)
              formData.append("id", this.app.id)
           }
           let loading = my(`
              <div class="d-flex fixed-top w-100 h-100 justify-content-center align-items-center" style="background-color: rgba(0, 0, 0, .2)">
                 <div class="spinner spinner-border"></div>
              </div>
           `).appendTo("body")
           
           my.ajax({
               data: formData,
               contentType: false,
               processData: false,
               type: "post",
               dataType: "json"
           })
           .then(json => {
              // alert(json)
               
               loading.remove()
               if ( !!json.error ) {
                   return Swal.fire({
                       icon: "error",
                       title: "Lỗi!",
                       text: json.error
                   })
               }
               
               if ( json.exists === false ) {
                   if ( !formData.get("replace") ) {
return Swal.fire({
  title: 'Dữ liệu đã tồn tại',
  text: "Ban có muốn thay thế nó không?",
  icon: 'question',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
     this.submit(e, true)
  }
})
                   }
               }
               
               Swal.fire({
                   icon: "success",
                   title: "Thành công",
                   text: replace ? "Thay thế dữ liệu thành công" : "Tải lên thành công"
               })
           })
           .catch(e => {
               alert(e + "")
               loading.remove()
           })
        }
    }
})

const SimpleMDE = EasyMDE;

app.MDE = new EasyMDE({
      //element: "#description",
      spellChecker: false,
      autosave: {
          enabled: false,
            unique_id: "description"
      },
     //autofocus: true,
     //promptURLs: false,
     toolbar: [
        { name: "bold", action: SimpleMDE.toggleBold, className: "fa fa-bold", title: "Bold" },
        { name: "italic", action: SimpleMDE.toggleStrikethrough, className: "fa fa-strikethrough", title: "Strikethrough" },
        { name: "strikethrough", action: SimpleMDE.toggleItalic, className: "fa fa-italic", title: "Italic" },
        { name: "heading-1", action: SimpleMDE.toggleHeadingBigger, className: "fa fa-header fa-header-x", title: "Bold" },
        { name: "heading-1", action: SimpleMDE.toggleHeading1, className: "fa fa-header fa-header-x fa-header-1", title: "Bold" },
        { name: "heading-2", action: SimpleMDE.toggleHeading2, className: "fa fa-header fa-header-x fa-header-2", title: "Bold" },
        { name: "heading-3", action: SimpleMDE.toggleHeading3, className: "fa fa-header fa-header-x fa-header-3", title: "Bold" },
                    "|",
        { name: "code", action: SimpleMDE.toggleCodeBlock, className: "fa fa-code", title: "Code" },
        { name: "quote", action: SimpleMDE.toggleBlockquote, className: "fa fa-quote-left", title: "Quote" },
        { name: "unordered-list", action: SimpleMDE.toggleUnorderedList, className: "fa fa-list-ul", title: "Generic List" },
        { name: "ordered-list", action: SimpleMDE.toggleOrderedList, className: "fa fa-list-ol", title: "Numbered List" },
        { name: "table", action: SimpleMDE.drawTable, className: "fa fa-table", title: "Insert Table" },
        { name: "horizontal-rule", action: SimpleMDE.drawHorizontalRule, className: "fa fa-minus", title: "Insert Horizontal Line" },
        { name: "clean-block", action: SimpleMDE.cleanBlock, className: "fa fa-eraser fa-clean-block", title: "Clean block" },
"|",
        { name: "bold", action: SimpleMDE.drawLink, className: "fa fa-link", title: "Create Link" },
                    "|",
          { name: "preview", action: SimpleMDE.togglePreview, className: "fa fa-eye no-disable", title: "Toggle Preview"},
          { name: "side-by-side", action: SimpleMDE.toggleSideBySide, className: "fa fa-columns no-disable no-mobile",title: "Toggle Side by Side"},
          { name: "fullscreen", action: SimpleMDE.toggleFullScreen, className: "fa fa-arrows-alt no-disable no-mobile", title: "Toggle Fullscreen"},
                    "|",
           { name: "undo", action: SimpleMDE.togglePreview, className: "fa fa-undo no-disable", title: "Undo"},
           { name: "redo", action: SimpleMDE.togglePreview, className: "fa fa-repeat no-disable", title: "Redo"}
       ]
})
    </script>
    <style>
body {
    background-color: #eee;
    font-weight: 400;
}

.header__avatar {
    margin-right: 10px;
}

.header__avatar--icon {
    width: 96px;
    height: 96px;
}

.header {
    padding: 20px 15px 24px 15px;
    background-color: #fff;
    box-shadow: 0 2px 2px rgba(0, 0, 0, .2);
}

.app-title {
    font-size: 36px !important;
    padding-bottom: 8px !important;
}

.dev-title {
    font-size: 24px !important;
    color: rgba(0, 0, 0, .8) !important;
}

@media screen and (max-width: 768px) {
    .app-title {
        font-size: 26px !important
    }
    .dev-title {
        font-size: 18px !important
    }
}


.main {
    padding-left: 10px;
    padding-right: 10px;
}

.bg-white {
    background-color: #fff !important;
}

.no-input {
    -webkit-appearance: none;
    display: inline-block;
    width: 100%;
    border: 0;
}

.form-group {
    padding-top: 30px !important;
}
    </style>
    </body>
</html>