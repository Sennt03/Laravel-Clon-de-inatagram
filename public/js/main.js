window.addEventListener('load', function(){
    const URL = 'http://proyecto-laravel.com.devel'
    var likes = document.getElementsByClassName('btn-like')
    
    for(let i = 0; i<likes.length; i++){
        likes[i].addEventListener('click', function(){
            let like = false
            let vacio = 'far'
            let lleno = 'fas'
            
            this.classList.forEach(clase => {
                if(clase == vacio){
                    like = true
                }
            })
            if(like){
                this.classList.add(lleno)
                this.classList.remove(vacio)
                
                console.log(this.getAttribute('data-id'))
                fetch(URL+'/like/'+this.getAttribute('data-id'))
                .then((res) => res.json())
                .then(data => console.log('like'))
                .catch((err) => {
                    console.log(err)
                })
            }else{
                this.classList.add(vacio)
                this.classList.remove(lleno)
                
                console.log(this.getAttribute('data-id'))
                fetch(URL+'/dislike/'+this.getAttribute('data-id'))
                .then((res) => res.json())
                .then(data => console.log('dislike'))
                .catch((err) => {
                    console.log(err)
                })
            }
        })
    }
    
    
})