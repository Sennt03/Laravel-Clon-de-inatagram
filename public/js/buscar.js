window.addEventListener('load', function(){
    URL = 'http://proyecto-laravel.com.devel'
    let buscador =  document.querySelector('#buscador')
    buscador.addEventListener('submit', function(event){
        let busqueda = document.getElementById('search').value
        this.setAttribute('action', URL+'/usuarios/'+busqueda)
    })
})