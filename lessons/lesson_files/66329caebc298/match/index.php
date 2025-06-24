<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MATCHING Game</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background-color: #5372ef;
    }

    .container {
      width: 90%;
      max-width: 37.5em;
      background-color: #ffffff;
      padding: 3em 0.5em;
      position: absolute;
      transform: translate(-50%, -50%);
      top: 50%;
      left: 50%;
      border-radius: 0.8em;
    }

    h3 {
      text-align: center;
      width: 60%;
      margin: 0 auto 2em auto;
      font-size: 1.2em;
      font-weight: 600;
      letter-spacing: 0.03em;
      line-height: 1.8em;
      color: #010c39;
    }

    .draggable-objects,
    .drop-points {
      display: flex;
      justify-content: space-around;
      padding: 2em;
    }

    .draggable-image {
      width: 8em;
      cursor: move;
    }

    img {
      width: 8em;
      filter: drop-shadow(0 0.3em 0.9em rgba(0, 0, 0, 0.25));
    }

    .countries {
      width: 10em;
      height: 8em;
      display: grid;
      place-items: center;
      border: 0.25em dashed #010c39;
      border-radius: 0.8em;
    }

    .dropped {
      padding: 0;
      background-color: #e5ffc8;
    }

    .controls-container {
      position: absolute;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
      width: 100%;
      background-color: #5372ef;
      flex-direction: column;
      top: 0;
    }

    .controls-container button {
      font-size: 1.12em;
      padding: 0.8em 1em;
      border-radius: 0.2em;
      border: none;
      outline: none;
      color: #010c39;
      letter-spacing: 0.06em;
      cursor: pointer;
    }

    .controls-container p {
      color: #ffffff;
      font-size: 2em;
      margin-bottom: 1em;
    }

    .hide {
      display: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <h3>Drag & Drop The LOGO Over Their Respective  Names</h3>
    <div class="draggable-objects"></div>
    <div class="drop-points"></div>
  </div>
  <div class="controls-container">
    <p id="result"></p>
    <button id="start">Start Game</button>
  </div>
  <script>
      
      
      /*



cop paste to all page start





*/
      
      
       // Function to call the addscore.php script in the background
    const callAddScorePHP = () => {
    const xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Successful response from server
              //  alert("Successfully added score!");
            } else {
                // Error response from server
              //  alert("Error: Unable to add score.");
            }
        }
    };

    xhr.onerror = function () {
        console.error('Error occurred during XMLHttpRequest:', xhr.statusText);
        alert('An error occurred. Please try again later.');
    };

    const score = 100; // Replace `yourVariableName` with your actual variable name
    const url = '../../../../scoreadd.php?score=' + encodeURIComponent(score);
        //this 4 level for file type game.for direct html or php use only 3 level.
    xhr.open('GET', url, true);
    xhr.send();
};

/*



cop paste to all page end





*/
      
      
    // JavaScript code goes here
    //Initial References
    let draggableObjects;
    let dropPoints;
    const startButton = document.getElementById("start");
    const result = document.getElementById("result");
    const controls = document.querySelector(".controls-container");
    const dragContainer = document.querySelector(".draggable-objects");
    const dropContainer = document.querySelector(".drop-points");
    const data = [
        "C HASH",  
      "STACK",
      "ARRAY",
      "QUEUE",
      "PHP",
      "PYTHON",
      "SQL",
      "HTML",
      "CSS",
      "RUBY",
      "JAVA",
      "JAVASCRIPT",
      
    ];

    let deviceType = "";
    let initialX = 0,
      initialY = 0;
    let currentElement = "";
    let moveElement = false;

    //Detect touch device
    const isTouchDevice = () => {
      try {
        //We try to create Touch Event (It would fail for desktops and throw error)
        document.createEvent("TouchEvent");
        deviceType = "touch";
        return true;
      } catch (e) {
        deviceType = "mouse";
        return false;
      }
    };

    let count = 0;

    //Random value from Array
    const randomValueGenerator = () => {
      return data[Math.floor(Math.random() * data.length)];
    };

 

    //paste in each game  
   // Win Game Display
// Function to handle the win event
    const stopGame = () => {
        controls.classList.remove("hide");
        startButton.classList.remove("hide");
        
    };

   
      
      
      
    //Drag & Drop Functions
    function dragStart(e) {
      if (isTouchDevice()) {
        initialX = e.touches[0].clientX;
        initialY = e.touches[0].clientY;
        //Start movement for touch
        moveElement = true;
        currentElement = e.target;
      } else {
        //For non touch devices set data to be transfered
        e.dataTransfer.setData("text", e.target.id);
      }
    }

    //Events fired on the drop target
    function dragOver(e) {
      e.preventDefault();
    }

    //For touchscreen movement
    const touchMove = (e) => {
      if (moveElement) {
        e.preventDefault();
        let newX = e.touches[0].clientX;
        let newY = e.touches[0].clientY;
        let currentSelectedElement = document.getElementById(e.target.id);
        currentSelectedElement.parentElement.style.top =
          currentSelectedElement.parentElement.offsetTop - (initialY - newY) + "px";
        currentSelectedElement.parentElement.style.left =
          currentSelectedElement.parentElement.offsetLeft -
          (initialX - newX) +
          "px";
        initialX = newX;
        initialY - newY;
      }
    };

    const drop = (e) => {
      e.preventDefault();
      //For touch screen
      if (isTouchDevice()) {
        moveElement = false;
        //Select country name div using the custom attribute
        const currentDrop = document.querySelector(`div[data-id='${e.target.id}']`);
        //Get boundaries of div
        const currentDropBound = currentDrop.getBoundingClientRect();
        //if the position of flag falls inside the bounds of the countru name
        if (
          initialX >= currentDropBound.left &&
          initialX <= currentDropBound.right &&
          initialY >= currentDropBound.top &&
          initialY <= currentDropBound.bottom
        ) {
          currentDrop.classList.add("dropped");
          //hide actual image
          currentElement.classList.add("hide");
          currentDrop.innerHTML = ``;
          //Insert new img element
          currentDrop.insertAdjacentHTML(
            "afterbegin",
            `<img src= "${currentElement.id}.png">`
          );
          count += 1;
        }
      } else {
        //Access data
        const draggedElementData = e.dataTransfer.getData("text");
        //Get custom attribute value
        const droppableElementData = e.target.getAttribute("data-id");
        if (draggedElementData === droppableElementData) {
          const draggedElement = document.getElementById(draggedElementData);
          //dropped class
          e.target.classList.add("dropped");
          //hide current img
          draggedElement.classList.add("hide");
          //draggable set to false
          draggedElement.setAttribute("draggable", "false");
          e.target.innerHTML = ``;
          //insert new img
          e.target.insertAdjacentHTML(
            "afterbegin",
            `<img src="${draggedElementData}.png">`
          );
          count += 1;
        }
      }
    
        
    
        
        
  //here win has limit i utilizing it .      
        //Win
      if (count == 3) {
        result.innerText = `You Won!`;
        stopGame();
          
          // code to run score to db adding 
          
         
        // Call the addscore.php script in the background
/*



cop paste to all page start





*/
       //this   
          
          callAddScorePHP();
          
          
      
          
          /*



cop paste to all page end





*/
          
      }
    };

    
      
      
      
      
 



     
      
      
      
      
      
      
      
      
      
   
      
      
    //Creates flags and countries
    const creator = () => {
      dragContainer.innerHTML = "";
      dropContainer.innerHTML = "";
      let randomData = [];
      //for string random values in array
      for (let i = 1; i <= 3; i++) {
        let randomValue = randomValueGenerator();
        if (!randomData.includes(randomValue)) {
          randomData.push(randomValue);
        } else {
          //If value already exists then decrement i by 1
          i -= 1;
        }
      }
      for (let i of randomData) {
        const flagDiv = document.createElement("div");
        flagDiv.classList.add("draggable-image");
        flagDiv.setAttribute("draggable", true);
        if (isTouchDevice()) {
          flagDiv.style.position = "absolute";
        }
        flagDiv.innerHTML = `<img src="${i}.png" id="${i}">`;
        dragContainer.appendChild(flagDiv);
      }
      //Sort the array randomly before creating country divs
      randomData = randomData.sort(() => 0.5 - Math.random());
      for (let i of randomData) {
        const countryDiv = document.createElement("div");
        countryDiv.innerHTML = `<div class='countries' data-id='${i}'>
        ${i.charAt(0).toUpperCase() + i.slice(1).replace("-", " ")}
        </div>
        `;
        dropContainer.appendChild(countryDiv);
      }
    };

    //Start Game
    startButton.addEventListener(
      "click",
      (startGame = async () => {
        currentElement = "";
        controls.classList.add("hide");
        startButton.classList.add("hide");
        //This will wait for creator to create the images and then move forward
        await creator();
        count = 0;
        dropPoints = document.querySelectorAll(".countries");
        draggableObjects = document.querySelectorAll(".draggable-image");

        //Events
        draggableObjects.forEach((element) => {
          element.addEventListener("dragstart", dragStart);
          //for touch screen
          element.addEventListener("touchstart", dragStart);
          element.addEventListener("touchend", drop);
          element.addEventListener("touchmove", touchMove);
        });
        dropPoints.forEach((element) => {
          element.addEventListener("dragover", dragOver);
          element.addEventListener("drop", drop);
        });
      })
    );
  </script>
    


 
    
  
    
    
    
    
    
</body>
</html>
