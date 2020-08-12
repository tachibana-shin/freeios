<body>
<script>
    class Iframe {
        constructor(...props) {
            this.el = document.createElement("iframe")
            this.el.src = props[0]
            this.size = "lg"
            this.height = "500px"
            document.body.appendChild(this.el)
        }
        
        set width( size ) {
            this.el.width = size
        }
        
        set height( size ) {
            this.el.height = size
        }
        
        set size( type ) {
           switch ( type ) {
               case "xs":
                   this.width = "575px"
                   break
               case "sm":
                   this.width = "576px"
                   break
               case "md":
                   this.width = "768px"
                   break
               case "lg":
                   this.width = "992px"
                   break
               case "xl":
                   this.width = "1200px"
           }
        }
        
        reload() {
            this.el.contentWindow.location.reload()
        }
    }
    
    const iosCodeVn = new Iframe("https://ios.codevn.net")
    const freeiOS = new Iframe("https://myjs-shinigami.000webhostapp.com")
    
    function changeSize( type ) {
        iosCodeVn.size = type
        freeiOS.size = type
    }
</script>
<button onclick="changeSize('xs')"> XS </button>
<button onclick="changeSize('sm')"> SM </button>
<button onclick="changeSize('md')"> MD </button>
<button onclick="changeSize('lg')"> LG </button>
<button onclick="changeSize('xl')"> XL </button>

<br>

<button onclick="iosCodeVn.reload()"> Reload Codevn </button>
<button onclick="freeiOS.reload()"> Reload FreeiOS </button>

<style>
    iframe:nth-child(2) {
        margin-top: 100px;
    }
    
    button {
        width: 100px;
        height: 50px;
    }
</style>
</body>