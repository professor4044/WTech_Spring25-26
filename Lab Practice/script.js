function validateForm() {
    let firstName=document.getElementById("firstname").Value;
    let lastName=document.getElementById("lastname").value;
    let email=document.getElementById("email").value;
    let phone=document.getElementById("phonenumber").value;
    let message=document.getElementById("message").value;
}
if(firstName==="" || lastName==="" || email==="" || phoneNumber==="" || message===""){
    alert("Field Value need to be filled up");
    return false;
}
else{
    console.log("First Name: " + firstName);
    console.log("Last Name: " + lastName);
    console.log("Email: " + email);
    console.log("Phone: " + phonenumber);
    console.log("Message: " + message);

    alert("Submit Succesfully!");
    return false;
}