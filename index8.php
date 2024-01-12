<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Scrolling Card UI With Flexbox</title>
  <style>
    body {
      font-family: 'Rubik', sans-serif;

      margin: 50px 0;
    }

    .container {
      max-width: 1400px;
      padding: 0 15px;
      margin: 0 auto;
    }

    h2 {
      font-size: 32px;
      margin-bottom: 1em;
    }

    .cards {
      display: flex;
      padding: 25px 0px;
      list-style: none;
      overflow-x: scroll;
      -ms-scroll-snap-type: x mandatory;
      scroll-snap-type: x mandatory;
    }

    .card {
  display: flex;
  flex-direction: column;
  flex: 0 0 300px;
  padding: 20px;
  background: var(--white);
  border-radius: 12px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 15%);
  scroll-snap-align: start;
  transition: all 0.2s;
  height: 200px; /* Adjust the height as needed */
}
    .card:not(:last-child) {
      margin-right: 10px;
    }

    .card:hover {
      color: #fff;
      background: #013289; /* Changed color */
    }

    .card .card-title {
      font-size: 14px; /* Adjusted font size */
    }

    .card .card-content {
  margin: 20px 0;
  max-width: 100%; /* Update from 85% to 100% */
}

    .card .card-link-wrapper {
      margin-top: auto;
    }

    .card .card-link {
      display: inline-block;
      text-decoration: none;
      color: white;
      background: #013289; /* Changed color */
      padding: 6px 12px;
      border-radius: 8px;
      transition: background 0.2s;
    }

    .card:hover .card-link {
      background: #002766; /* Darker shade for hover */
    }

    .cards::-webkit-scrollbar {
      height: 12px;
    }

    .cards::-webkit-scrollbar-thumb,
    .cards::-webkit-scrollbar-track {
      border-radius: 92px;
    }

    .cards::-webkit-scrollbar-thumb {
      background: #002766; /* Darker shade for scrollbar */
    }

    .cards::-webkit-scrollbar-track {
      background: #edf2f4;
    }
    /* Below Scrolling Card Section Styles */
.audio-section {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

/* Left Section Styles */
.left-section {
    flex: 1;
    padding: 20px;
    background-color: #f0f0f0;
    border-radius: 8px;
}

#audioText {
    width: 100%;
    height: 100px;
    margin-bottom: 10px;
}

#recordButton {
    padding: 10px;
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

/* Right Section Styles */
.right-section {
    flex: 1;
    padding: 20px;
    background-color: #f0f0f0;
    border-radius: 8px;
}

#textInput {
    width: 100%;
    height: 100px;
    margin-bottom: 10px;
}

#fileInput {
    margin-bottom: 10px;
}

#uploadButton {
    padding: 10px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

  </style>
</head>
<body>
  <div class="container">
    <h2>Scrolling Card UI With Flexbox</h2>
    <ul class="cards">
      <!-- Repeat this li block for each card -->
      <li class="card">
        <div>
          <h3 class="card-title">Service 1</h3>
          <div class="card-content">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
          </div>
        </div>
        <div class="card-link-wrapper">
          <a href="#" class="card-link">Learn More</a>
        </div>
      </li>
      <!-- Repeat this li block for each card -->
      <!-- Repeat the above li block for the next 9 cards -->
      <li class="card">
        <div>
          <h3 class="card-title">Service 2</h3>
          <div class="card-content">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
          </div>
        </div>
        <div class="card-link-wrapper">
          <a href="#" class="card-link">Learn More</a>
        </div>
      </li>
      <li class="card">
        <div>
          <h3 class="card-title">Service 2</h3>
          <div class="card-content">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
          </div>
        </div>
        <div class="card-link-wrapper">
          <a href="#" class="card-link">Learn More</a>
        </div>
      </li>
      <li class="card">
        <div>
          <h3 class="card-title">Service 2</h3>
          <div class="card-content">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
          </div>
        </div>
        <div class="card-link-wrapper">
          <a href="#" class="card-link">Learn More</a>
        </div>
      </li>
      <li class="card">
        <div>
          <h3 class="card-title">Service 3</h3>
          <div class="card-content">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
          </div>
        </div>
        <div class="card-link-wrapper">
          <a href="#" class="card-link">Learn More</a>
        </div>
      </li>
      <!-- Repeat the above li block for the next 7 cards -->
    </ul>
  </div>
<!-- Below Scrolling Card Section -->
<!-- Left Section -->
<div class="left-section">
    <div class="speaker" style="display: flex;justify-content: space-between;width: 13rem;box-shadow: 0 0 13px #0000003d;border-radius: 5px;">
        <p id="action" style="color: grey;font-weight: 800; padding: 0; padding-left: 2rem;"></p>
        <button onclick="startSpeechRecog()" style="border: transparent;padding: 0 0.5rem;">
            Start
        </button>
        <button onclick="stopSpeechRecog()" style="border: transparent;padding: 0 0.5rem;">
            Stop
        </button>
    </div>
    <textarea id="output" class="hide" rows="5" style="width: 100%; margin-top: 10px;"></textarea>
</div>

<!-- JavaScript for Speech Recognition -->
<script>
    let recognition;
    let lastTranscript = '';

    startSpeechRecog = () => {
        document.getElementById("output").value = "Loading text...";
        var output = document.getElementById('output');
        var action = document.getElementById('action');
        recognition = new webkitSpeechRecognition();
        recognition.onstart = () => {
            action.innerHTML = "Listening...";
        }
        recognition.onresult = (e) => {
            var transcript = e.results[0][0].transcript;
            lastTranscript += transcript + ' ';
            output.value = lastTranscript;
            output.classList.remove("hide");
            action.innerHTML = "";
        }
        recognition.start();
    }

    stopSpeechRecog = () => {
        if (recognition) {
            recognition.stop();
            recognition = null;
        }
    }
</script>

<!-- Right Section with Text Field and Upload Button -->
    <div class="right-section">

        <input type="file" id="fileInput" />
        <button id="uploadButton">Upload Document</button>
    </div>
</div>
</body>
</html>
