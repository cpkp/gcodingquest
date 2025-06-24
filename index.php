

<!-- CODE REFINE THINGS         
<?php
// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<script>
window.history.forward();
function noBack() { window.history.forward(); }
</script>

<script>
if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_RELOAD) {
    window.location.href = "logout.php"; // Redirect to logout page
}
</script>


-->
<script>
window.history.forward();
function noBack() { window.history.forward(); }
</script>



<!-- end refine-->

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login/sign</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        
        
        .error-message {
            color: red;
            font-weight: bold;
        }
        
        .success-message {
            color: green;
            font-weight: bold;
        }
    </style>
    <style>
/* Style The Dropdown Button */
.dropdown-btn {

  background:rgba(0,0,2,0.7);
  color:whitesmoke;
  padding: 8px 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
  border-radius: 3px;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
    padding-bottom:50px;
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color:black;
  min-width: 160px;
 
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  border-radius: 3px;
}

/* Options inside the dropdown */
.dropdown-option {
  color: white;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  cursor: pointer;
}

/* Change color of dropdown options on hover */
.dropdown-option:hover {
  background-color:maroon;
}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropdown-btn {
  background-color:darkgoldenrod;
}
</style>
</head>
<body>
<div class="hero">
    <div class="form-box">
        <div class="social-icons">
            <h1>GCODING</h1>
        </div>
        <div class="button-box">
            <div id="btn"></div>
            <button type="button" class="toggle-btn" onclick="login()">Login</button>
            <button type="button" class="toggle-btn" onclick="register()">Register</button>
        </div>
       <?php
session_start();

// Check if the registration form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the registration logic file
    include 'registration_logic.php';

    // Retrieve the form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $selectedRole = $_POST['selectedRole'];

    // Perform registration based on the selected role
    if ($selectedRole == "student") {
        register_student($username, $password);
    } elseif ($selectedRole == "teacher") {
        register_teacher($username, $password);
    } elseif ($selectedRole == "parent") {
        register_parent($username, $password);
    }
}

// Display success or error message, if any
if(isset($_SESSION['error'])) {
    echo "<script>alert('" . $_SESSION['error'] . "')</script>";
    unset($_SESSION['error']); // Clear the error message after displaying it
} elseif(isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "')</script>";
    unset($_SESSION['message']); // Clear the success message after displaying it
}
?>

        <form action="login.php" method="post" id="login" class="input-group">
            <input type="text" name="username" class="input-field" placeholder="username" required> 
            <label for ="username" class="input-label">Enter username</label>            

            <input type="password"  name="password" id="myinput" class="input-field" placeholder="enter password" required>  
            <label for ="password" class="input-label">Enter Password</label> 
            <span class="eye" onclick="myFunction()"> 
                <i id="hide1" class="fa fa-eye"></i>
                <i id="hide2" class="fa fa-eye-slash"></i>
            </span> 
            
   
    
            <div class="dropdown">
    <button class="dropdown-btn" id="selected-role-login">Select Role</button>
    <input type="hidden" id="selected-role-input-login" name="selectedRole">
   <div class="dropdown-content">
      <div class="dropdown-option" onclick="selectRole('Admin')">Admin</div>
      <div class="dropdown-option" onclick="selectRole('Parent')">Parent</div>
      <div class="dropdown-option" onclick="selectRole('Student')">Student</div>
      <div class="dropdown-option" onclick="selectRole('Teacher')">Teacher</div>
    </div>
</div>

            
            
            <button id="sbtn" type="submit" class="submit-btn">
                <p id="sbtnt">Login</p>
                <div class="tick">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M20.516 13.453l3.484-.891-1.932-7.562-3.526.891.196.753c-1.796.24-2.544-.226-4.459-1.226-.498-.257-.972-.418-1.408-.418-.592 0-1.108.268-1.503.714l-.491.552c-1.956-1.525-3.178-.405-4.505.084-.364.135-.793.185-1.087.202l.173-.662-3.526-.89-1.932 7.562 3.484.891.182-.695c.316.06 1.509.291 1.733.347-.649 1.055.01 2.357 1.199 2.495.226.545.741.932 1.34 1.003.225.544.736.928 1.332.997.33.815 1.305 1.267 2.232.863.352.354.841.537 1.356.537.703 0 1.349-.344 1.674-1.012.574-.12 1.052-.498 1.296-1.01.552-.115 1.031-.47 1.285-1.002.759-.154 1.378-.773 1.457-1.602.031-.312-.03-.624-.155-.91.289-.16 1.442-.647 1.886-.833l.215.822zm.686-6.996l1.338 5.24-1.165.298-1.366-5.237 1.193-.301zm-18.577 5.538l-1.165-.298 1.338-5.24 1.193.301-1.366 5.237zm3.766 2.484c-.294-.221-.331-.645-.08-.942l.61-.749c.249-.298.69-.363.986-.14.295.223.33.644.08.944l-.609.747c-.25.299-.693.361-.987.14zm1.336 1c-.296-.224-.337-.636-.086-.936l.616-.754c.25-.3.69-.363.984-.142.295.222.33.646.082.943l-.617.755c-.25.301-.682.356-.979.134zm1.336 1c-.295-.222-.333-.645-.082-.945l.609-.745c.251-.299.69-.364.986-.142.295.223.331.645.08.944l-.608.747c-.25.3-.691.361-.985.141zm2.93.108l-.61.75c-.251.302-.691.363-.986.142-.295-.222-.331-.645-.082-.943l.612-.751c.252-.298.693-.362.987-.139.296.221.332.644.079.941zm1.28 1.11c-.12.092-.266.138-.415.138-.16 0-.315-.069-.448-.176l.358-.441c.159-.187.269-.412.332-.65l.24.212c.251.285.218.694-.067.917zm3.873-3.017c-.289.222-.719.168-.967-.114l-1.944-1.669c-.16-.138-.37.107-.208.242l1.896 1.628c.248.285.217.696-.068.916-.276.218-.712.181-.969-.114l-1.491-1.308c-.161-.139-.37.102-.213.241l1.457 1.279c.249.285.211.686-.075.909-.28.218-.708.184-.96-.106l-.45-.402-.002-.225c-.089-.78-.711-1.352-1.449-1.434-.224-.547-.737-.93-1.335-.998-.218-.535-.726-.93-1.334-1-.397-.975-1.636-1.334-2.549-.679-.425-.133-1.852-.45-2.434-.564l.836-3.204c.783-.037 1.694-.132 2.902-.705.864-.411 1.278-.599 2.067-.013-.507.507-1.027.955-1.562 1.268-.48.28-.688.837-.531 1.419.181.668.856 1.343 1.96 1.343s2.924-1.014 3.279-1.502c1.472 1.391 2.902 2.684 4.143 3.796.35.39.285.776.001.996zm.526-2.537c-.837-.753-2.728-2.463-3.407-3.143-.289-.288-.691-.619-1.244-.619-.49 0-.878.267-1.128.468-.573.462-2.019 1.378-2.592.92 1.161-.754 2.208-1.943 3.192-3.063.24-.273.587-.219 1.1.044 2.153 1.125 3.007 1.666 5.538 1.394l.779 2.987c-.5.199-1.823.78-2.238 1.012z"/></svg>
                </div>    
            </button> 
        </form>
        <form action="registration_logic.php" method="post" id="register" class="input-group">
            <input type="text" name="username" class="input-field" placeholder="enter username" required>
            <label for ="username" class="input-label">Enter username</label>  
            <input id="myinput1" type="password" name="password" class="input-field" placeholder="enter password" required> 
            <label for ="password" class="input-label">Enter Password</label>
            <span class="eye1" onclick="myFunction1()"> 
                <i id="hide3" class="fa fa-eye"></i>
                <i id="hide4" class="fa fa-eye-slash"></i>
            </span> 
  
    
         <div class="dropdown">
    <button class="dropdown-btn" id="selected-role-register">Select Role</button>
    <input type="hidden" id="selected-role-input-register" name="selectedRole">
    
             <div class="dropdown-content">
      <div class="dropdown-option" onclick="selectRole('Parent')">Parent</div>
      <div class="dropdown-option" onclick="selectRole('Student')">Student</div>
      <div class="dropdown-option" onclick="selectRole('Teacher')">Teacher</div>
    </div>
</div>
   
            

            <button id="sbtn1" type="submit" class="submit-btn">
                <p id="sbtnt1">Register</p>
                <div class="tick1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                        <path fill="transparent" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                    </svg>
                </div>
            </button> 
        </form>
    </div>
</div>
<script>
    var x = document.getElementById("login");
    var y = document.getElementById("register");
    var z = document.getElementById("btn");
   
    function register(){
        x.style.left="-400px";
        y.style.left="50px";
        z.style.left="110px";
    }
    
    function login(){
        x.style.left="50px";
        y.style.left="450px";
        z.style.left="0px";
    }
</script>
<script>
    
    function myFunction(){
        var a =document.getElementById("myinput");
        var b =document.getElementById("hide1");
        var c =document.getElementById("hide2");

        if(a.type === 'password'){
            a.type = "text";
            b.style.display= "block";
            c.style.display= "none";
        }
        else{
            a.type = "password";
            b.style.display= "none";
            c.style.display= "block";
        }
    }
</script>
<script>
   function myFunction1(){
        var d =document.getElementById("myinput1");
        var e =document.getElementById("hide3");
        var f =document.getElementById("hide4");

        if(d.type === 'password'){
            d.type = "text";
            e.style.display= "block";
            f.style.display= "none";
        }
        else{
            d.type = "password";
            e.style.display= "none";
            f.style.display= "block";
        }
   }
</script>
<script>
    var sbtn1 = document.getElementById("sbtn1");
    var sbtnt1 = document.getElementById("sbtnt1");

       sbtn1.onclick = function(){
           sbtnt1.innerHTML = "Thanks";
           sbtn1.classList.add("active1");
       }
</script>
<script>
    var sbtn = document.getElementById("sbtn");
    var sbtnt = document.getElementById("sbtnt");

       sbtn.onclick = function(){
           sbtnt.innerHTML = "Welcome";
           sbtn.classList.add("active");
       }
</script>
    <script>
function selectRole(role) {
    document.getElementById("selected-role-login").innerText = role; // Update dropdown button text for login form
    document.getElementById("selected-role-input-login").value = role; // Set hidden input value for login form
    
    document.getElementById("selected-role-register").innerText = role; // Update dropdown button text for register form
    document.getElementById("selected-role-input-register").value = role; // Set hidden input value for register form
}

    </script>
</body>
</html>

