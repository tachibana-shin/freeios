<?
  require_once __DIR__."/../modules/sql_connect.php";
  require_once __DIR__."/modules/Auth.php";
  
   if ( !$auth -> checkLogin() )
      header("Location: login");
      
  $sql -> query("create table if not exists AccountActive (

     id tinytext not null,
     password tinytext not null,
     hide tinyint(1) default 0
  )");
  
  if ( isset($_POST["submit"]) || (isset($_POST["ajax"]) && !!$_POST["ajax"]) ) {
     
     if (
         isset($_POST["ids"]) &&
         is_array($_POST["ids"]) &&
         isset($_POST["pass"]) &&
         is_array($_POST["pass"])
     ) {
     
        $sql -> query("truncate AccountActive");
        foreach ( $_POST["ids"] as $index => $value ) {
           if ( !isset($_POST["pass"][$index]) )
               continue;
           $sql -> query("insert into AccountActive (id, password) values ('$value', '".$_POST["pass"][$index]."')");
        }
     
        if ( isset($_POST["ajax"]) && !!$_POST["ajax"] ) {
             echo json_encode([
                "error" => $sql -> error
             ]);
             die();
        }
     }
     
     if ( isset($_POST["ajax"]) && !!$_POST["ajax"] ) {
         echo json_encode([
             "error" => "Error unknown."
         ]);
         die();
     }
  };
       
  // exists Table  AccountActive
       
  $result = $sql -> query("select id, password from AccountActive where hide = 0");
  echo $sql -> error;
  
  $ID_ACTIVE = [];
  
  if ( $result -> num_rows > 0 ) {
      while ( $row = $result -> fetch_array())
         array_push($ID_ACTIVE, $row);
  }
  
  $result -> free_result();

  //$sql -> query("insert into AccountActive ( id, password ) values ( 'icloud.com', 'my' )");
  //echo $sql -> error;
 // print_r($ID_ACTIVE);
?>




<!doctype html>

<html>

   <head>
   
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
      <!--link rel="stylesheet" href="https://nguyenthanh1995.github.io/lib/bootstrap.min.css">-->
      <link rel="stylesheet" href="https://nguyenthanh1995.github.io/lib/awesome pro/css/all.min.css">
      <link rel="stylesheet" href="/style.css">
      <script src="https://nguyenthanh1995.github.io/lib/vue.development.js"></script>
      <meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
      <script src="https://nguyenthanh1995.github.io/my-new.js"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.0/dist/sweetalert2.min.css">
	  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.0/dist/sweetalert2.min.js"></script>
   </head>
   <body>

      <div class="main" id="app">
      
         <div class="container">
            
            <!-- flex apps -->
            <div class="row">
               <div class="col-12 col-lg-8 pt-30px">                   
                  <div class="p-15px bg-white px-3 listWidget">
                     <form method="post" class="m-0 p-0 my-2 was-validated" @submit.prevent="update($event.target)">
                         <label> Các tài khoản </label> 
                             <table>
                                 <tr v-for="(item, index) in accounts">
                                    <td> <input class="no-input form-control" v-model="item.id" name="ids[]" required> </td>
                                    <td> <input class="no-input form-control" v-model="item.password" name="pass[]" required> </td>
                                    <td @click="trash.push(accounts.splice(index, 1)[0])">  <i class="fad fa-trash"></i> </td> 
                                </tr>
                             </table>
                             
                             <div v-if="accounts.length == 0" class="text-center text-secondary py-3">
                                Không có tài khoản nào
                            </div>
                     
                             <div class="d-flex justify-content-between mt-3">

                              <a class='btn btn-outline-dark' @click="accounts.push({})"> Thêm </a>
                                 <button class="btn btn-outline-primary" name="submit" type="submit"> Cập nhật </button>

                             </div>
                     
                     </form>
                     
                     <div class="m-p p-0 my-2" v-if="trash.length > 0">
                            <label> Thủng rác </label>
                             <table>
                                 <tr v-for="(item, index) in trash">
                                    <td> <input class="no-input" v-model="item.id" required> </td>
                                    <td> <input class="no-input" v-model="item.password" required> </td>
                                    <td @click="accounts.push(trash.splice(index, 1)[0])"> <i class="fad fa-trash-restore"></i> </td> 
                                    <td @click="trash.splice(index, 1)"> &times; </td> 
                                </tr>
                             </table>
                       </div>
                       
                     <div class="text-secondary small">
                        Tap to text editable!
                     </div>
                  </div>
               </div>
               
               <!-- -->
               
               
               <!-- -->
               
            </div>
            
            <!-- -->
           
         </div>
         
      </div>
      
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
      
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
      
      <script>
new Vue({
    el: "#app",
    data: {
        accounts: <?= json_encode($ID_ACTIVE) ?>,
        trash: []
    },
    methods: {
        update(e) {
            let data = new FormData(e)
            data.append("ajax", true)
            
            my.ajax({
                type: "post",
                data,
                contentType: false,
                dataType: "json"
            })
            .then((json) => {
                //alert(json)
                
                Swal.fire({
                    title: !!json.error ? "Lỗi" : "Thành công",
                      icon: !!json.error ? "error" : "success",
                      text: json.error
                })
            })
            .catch(() => {
                Swal.fire({
                    title: "Thất bại",
                      icon: "error"
                })
            })
        }
    }
})
      </script>

    <style>
    table {
        margin: 0 auto;
    }
    
    tr {
        border-top: 1px solid #ccc;
        background-color: #fff;
    }
    
    th {
        text-align: inherit;
        border: 1px solid #ddd;
        padding: 6px 13px;
    }
    
    td {
        border: 1px solid #ddd;
        padding: 6px 13px;
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
