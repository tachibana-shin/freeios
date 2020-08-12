<?php
   require_once __DIR__."/modules/Auth.php";
   if ( !$auth -> checkLogin() )
      header("Location: login");
      
   if ( !isset($_GET["file"]) || !$_GET["file"] )
      header("Location: /");
   
   $file = $_GET["file"];
   
  
   if ( isset($_POST["ediabled"]) && is_file("../markdown/$file.md") ) {
      file_put_contents("../markdown/$file.md", $_POST["ediabled"]);
      if ( isset($_POST["ajax"]) && !!$_POST["ajax"] ) {
          echo json_encode(["error" => 0]);
          die();
      }
   }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Page Title</title>
        <script src="https://nguyenthanh1995.github.io/lib/vue.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://unpkg.com/easymde@2.11.0/dist/easymde.min.css">
        <script src="https://unpkg.com/easymde@2.11.0/dist/easymde.min.js"></script>
        
        <script src="https://nguyenthanh1995.github.io/my-new.js"></script>


		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    </head>
    <body>
        <form method="post" action="" id="app" enctype="multipart/form-data">
            <div class="main mt-3">
                <div class="container-fluid bg-white py-3">
                    <div class="col-12 py-2">
                        Chế độ chỉnh sửa tệp tin <?= $file ?>.md 
                      <p class="small text-secondary"> Lưu ý: Mọi %WEB đều được hiển thị như địa chỉ webiste.</p>
                   </div>
                    
          
 <?php
    if ( !is_file("../markdown/$file.md") )
       echo "<h2 class='col-12'> Tệp này không tồn tại </h2>";
    else echo '
    <div class="form-group col-12">
    <textarea class="form-control" name="ediabled">'.file_get_contents("../markdown/$file.md").'</textarea>
                    </div>
                    
                    <div class="form-group col-12">
                        <button name="submit" type="submit" class="btn btn-primary btn-block"> Upload </button>
                    </div>';
    ?>
                </div>
            </div>
        </form>
    <script>

onerror = console.error = e => alert(e + "")

const SimpleMDE = EasyMDE;
if ( document.getElementsByTagName("textarea").length )
new EasyMDE({
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
/*
        { name: "image",
          action: () => {
            this.modalImage = true;
            this.$store.dispatch('getFiles');
          },
          className: "fa fa-image",
          title: "Upload Image", },*/
                    "|",
          { name: "preview", action: SimpleMDE.togglePreview, className: "fa fa-eye no-disable", title: "Toggle Preview"},
          { name: "side-by-side", action: SimpleMDE.toggleSideBySide, className: "fa fa-columns no-disable no-mobile",title: "Toggle Side by Side"},
          { name: "fullscreen", action: SimpleMDE.toggleFullScreen, className: "fa fa-arrows-alt no-disable no-mobile", title: "Toggle Fullscreen"},
                    "|",
           { name: "undo", action: SimpleMDE.togglePreview, className: "fa fa-undo no-disable", title: "Undo"},
           { name: "redo", action: SimpleMDE.togglePreview, className: "fa fa-repeat no-disable", title: "Redo"}
       ]
})

my("form").submit(e => {
    e.preventDefault()
    
    let data = new FormData(e.target)
    
    data.append("ajax", true)
    my.ajax({
        type: "post",
        data,
        contentType: false
    })
    .then(() => alert("Cập nhật thành công"))
    .catch(() => alert("Thất bại"))
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
    </style>
    </body>
</html>