<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    .balloon-button {
      background: linear-gradient(to right, rgba(255, 255, 255, 0.2) 50%, rgba(211, 211, 211, 0.1) 50%); /* White and light grey gradient */
      border: 2px solid transparent; /* No default border */
      border-bottom: 2px solid #007BFF; /* Blue border on only half of the bottom side */
      border-radius: 20px; /* Rounded edges */
      padding: 8px 15px;
      display: inline-flex; /* Display as inline-flex to keep width tight around content */
      align-items: center;
      justify-content: flex-start; /* Align content to the start (left) */
      cursor: pointer;
      transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .balloon-button:hover {
      transform: scale(1.1); /* Pop-out effect on hover */
      box-shadow: 0 0 10px rgba(0, 123, 255, 0.7); /* Shadow effect on hover */
    }

    .balloon-icon {
      color: #FFD700; /* Gold color for the brain icon */
    }

    .balloon-text {
      margin-left: 10px;
      color: #000; /* Black color for the text */
    }
  </style>
</head>
<body>

<div class="container mt-4">
    <div class="balloon-button">
      <div class="balloon-icon">
        <i class="fas fa-clipboard-list"></i> <!-- Font Awesome clipboard icon -->
      </div>
      <div class="balloon-text">
        Tell me about therapies? 
      </div>
      <div class="balloon-icon">
        <i class="fas fa-chevron-right"></i> <!-- Font Awesome right icon -->
      </div>
    </div>
  </div>

  <div class="container mt-4">
    <div class="balloon-button">
      <div class="balloon-icon">
        <i class="fas fa-id-card"></i> <!-- Font Awesome ID card icon -->
      </div>
      <div class="balloon-text">
        Tell me how to get a Disability card? 
      </div>
      <div class="balloon-icon">
        <i class="fas fa-chevron-right"></i> <!-- Font Awesome right icon -->
      </div>
    </div>
  </div>

  <div class="container mt-4">
    <div class="balloon-button">
      <div class="balloon-icon">
        <i class="fas fa-school"></i> <!-- Font Awesome school icon -->
      </div>
      <div class="balloon-text">
        What are my child's rights in a school ? 
      </div>
      <div class="balloon-icon">
        <i class="fas fa-chevron-right"></i> <!-- Font Awesome right icon -->
      </div>
    </div>
  </div>

  <div class="container mt-4">
    <div class="balloon-button">
      <div class="balloon-icon">
        <i class="fas fa-chalkboard-teacher"></i> <!-- Font Awesome teacher icon -->
      </div>
      <div class="balloon-text">
        Tell me how to teach my child? 
      </div>
      <div class="balloon-icon">
        <i class="fas fa-chevron-right"></i> <!-- Font Awesome right icon -->
      </div>
    </div>
  </div>


</body>
</html>
