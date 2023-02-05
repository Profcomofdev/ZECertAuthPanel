const downloadParchive = function(element){
    let password = element.getAttribute('password');
    if (password){
        alert('Here is your password for the p12 archive:' + password);
    }
}

try{
    if (localStorage.prefix == 'personal'){
        document.querySelector('.uk-navbar-item.uk-logo').href = '/'+localStorage.prefix;
    }
    let selection = document.querySelector('#forms-changer > select');
    selection.onchange = function(){
        if (selection.value == 'personal'){
            document.querySelector('form').setAttribute('action', '/personal/main/auth');
            localStorage.prefix = 'personal';
        }else{
            document.querySelector('form').setAttribute('action', '/manage/main/auth');
            localStorage.prefix = 'manage';
        }
    }
    if (selection.value == 'personal'){
        document.querySelector('form').setAttribute('action', '/personal/main/auth');
        localStorage.prefix = 'personal';
    }else{
        document.querySelector('form').setAttribute('action', '/manage/main/auth');
        localStorage.prefix = 'manage';
    }
}catch{
    console.log('Error checking form');
}