function validateForm() {
    let firstName=document.getElementById("firstname").value;
    let lastName=document.getElementById("lastname").value;
    let email=document.getElementById("email").value;
    let phonenumber=document.getElementById("phonenumber").value;
    let message=document.getElementById("message").value;

if(firstName==="" || lastName==="" || email==="" || phonenumber==="" || message===""){
    alert("Field Value need to be filled up");
    return false;
}
else{
    console.log("First Name: " + firstName);
    console.log("Last Name: " + lastName);
    console.log("Email: " + email);
    console.log("Phone: " + phonenumber);
    console.log("Message: " + message);

    return false;
}
}