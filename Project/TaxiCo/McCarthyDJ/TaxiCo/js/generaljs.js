function FormValidationCustomer(formName){
    if (formName=="custCreateForm"){
        let username = document.getElementById("username").value.trim();
        if (username == "" ){
            alert("Please enter a username");
            return false;
        }
    }
    let password = document.getElementById("password").value.trim();
    if (formName!="custloginForm"){
        let email = document.getElementById("email").value.trim();
        let phone = document.getElementById("phone").value.trim();
        if ( email==""||phone=="" ){
            alert("All information must be filled.");
            return false;
        }
        if (!(email.endsWith(".com")||email.endsWith(".net")||email.endsWith(".ie"))){
            alert("Email must end in .com, .net or .ie");
            return false;
        }
        if (!(email.includes("@",1))){
            alert("Email must contain 1 @ symbol, not in the first position  (Anne if you found this error, just put in a normal email :/)");
            return false;
        }
        
        if (phone.length!=10){
            alert("Phone number must be 10 charaters long.");
            return false;
        }
        if (phone.charAt(0)!="0" || phone.charAt(1)!="8"){
            alert("Phone number must begin with 08.");
            return false;
        }
    }
    

    if (password==""){
        alert("All information must be filled.");
        return false;
    }
    
    if (password.length<8){
        alert("Password must be at least 8 charaters long.");
        return false;
    }
    else{
        return true;
    }
    
}


