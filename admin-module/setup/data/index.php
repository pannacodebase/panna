<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard UI</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap">
  <!-- Bootstrap Icons CSS -->




  <script>
    window.console = window.console || function (t) { };
  </script>



</head>


<main class="main">
  <div class="responsive-wrapper">
    <div class="content-header">
      <div class="content-header-intro">
        <h2 id="dg" style="color:#013289;margin-left:0px;text-align:center"> Data Gathering for Training </h2>

      </div>
      <div class="content-header-actions">
        <a href="#" class="button" data-bs-toggle="modal" data-bs-target="#filterModal">
          <i class="ph-faders-bold"></i>
          <span>Filters</span>
        </a>
        <a href="#" class="button">
          <i class="ph-plus-bold"></i>
          <span>Add Topic</span>
        </a>
      </div>
      
      <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="filterModalLabel">Filter Options</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <!-- Filter options -->
              <div class="mb-4">
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="filterOption" value="behaviorSensory" class="me-2"> Behavior and Sensory
                </label>
                <hr>
              </div>
              <div class="mb-4">
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="filterOption" value="speechLanguage" class="me-2"> Speech & Language
                </label>
                <hr>
              </div>
              <div class="mb-4">
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="filterOption" value="specialEducation" class="me-2"> Special Education
                </label>
                <hr>
              </div>
              <div class="mb-4">
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="filterOption" value="socialInteractions" class="me-2"> Social
                  Interactions
                </label>
                <hr>
              </div>
              <div class="mb-4">
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="filterOption" value="academicAchievement" class="me-2"> Academic
                  Achievement
                </label>
                <hr>
              </div>
              <div class="mb-4">
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="filterOption" value="anxietyEmotionalRegulation" class="me-2"> Anxiety
                  and Emotional Regulation
                </label>
                <hr>
              </div>
              <div class="mb-4">
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="filterOption" value="independenceDailyLiving" class="me-2"> Independence
                  and Daily Living
                </label>
                <hr>
              </div>
              <div class="mb-4">
                <label class="d-flex align-items-center">
                  <input type="checkbox" name="filterOption" value="healthWellBeing" class="me-2"> Health and Well Being
                </label>
                <hr>
              </div>
              <!-- Add other filter options as needed -->

              <!-- Submit button -->
              <div class="text-center">
                <button type="button" class="btn btn-primary">Submit</button>
              </div>
            </div>



          </div>
        </div>
      </div>

    </div>
    <div class="content">
      <div class="content-panel">
        <div class="vertical-tabs">
          <a href="#" class="active">View all</a>
          <?php
          // Fetch categories from database
          $sql = "SELECT * FROM categories";
          $result = $conn->query($sql);

          // Check if there are rows in the result
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '<a href="#">' . $row['title'] . '</a>';
            }
          }
          ?>
        </div>
      </div>

      <div class="content-main">
        <div class="card-grid" id="cardGrid">
          <?php
          // Rewind the data pointer to the beginning for fetching cards
          if ($result->num_rows > 0) {
            // Fetch data and display in cards
            while ($row = $result->fetch_assoc()) {
              echo '<article class="card">';
              echo '<div class="card-header">';
              echo '<div>';
              echo '<span><img src="' . $row['image_url'] . '" alt="' . $row['name'] . '" /></span>';
              echo '<h3>' . $row['name'] . '</h3>';
              echo '</div>';
              echo '<label class="toggle">';
              echo '<input type="checkbox" ' . ($row['flag'] == 1 ? 'checked' : '') . '>';
              echo '<span></span>';
              echo '</label>';
              echo '</div>';
              echo '<div class="card-body">';
              echo '<p>' . $row['description'] . '</p>'; // Add a description column to your table
              echo '</div>';
              echo '<div class="card-footer">';
              echo '<a href="#">Contribute</a>';
              echo '</div>';
              echo '</article>';
            }
          } else {
            echo "0 results";
          }
          ?>
        </div>
        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center" id="pagination">
            <!-- Pagination links will be added dynamically using JavaScript -->
          </ul>
        </nav>
      </div>
    </div>
  </div>


  </div>
  </div>
</main>
<script src='https://unpkg.com/phosphor-icons'></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script id="rendered-js">
</script>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);// Fetch data from categories table
$sql = "SELECT * FROM topics";
$result = $conn->query($sql);

// Check if there are rows in the result
if ($result === false) {
  die("Error executing query: " . $conn->error);
}
$cardData = array(); // Array to store card data
if ($result->num_rows > 0) {
  // Fetch data and add to the cardData array
  while ($row = $result->fetch_assoc()) {
    $cardData[] = array(
      'title' => $row['title'],
      'icon' => $row['icon'],
      'content' => $row['content'],
    );
  }
}
?>

<script>
  function renderCards(pageNumber, pageSize, data) {
    const startIndex = (pageNumber - 1) * pageSize;
    const endIndex = startIndex + pageSize;

    const cardGrid = document.getElementById('cardGrid');
    cardGrid.innerHTML = ''; // Clear previous cards

    for (let i = startIndex; i < endIndex && i < data.length; i++) {
      const card = document.createElement('article');
      card.classList.add('card', 'mb-3');

      const cardHeader = document.createElement('div');
      cardHeader.classList.add('card-header');

      const headerContent = document.createElement('div');
      headerContent.innerHTML = `
        <span><img src="${data[i].icon}" alt="${data[i].title}" /></span>
        <h3>${data[i].title}</h3>
      `;

      cardHeader.appendChild(headerContent);

      const toggleLabel = document.createElement('label');
      toggleLabel.classList.add('toggle');

      const toggleInput = document.createElement('input');
      toggleInput.setAttribute('type', 'checkbox');
      toggleInput.setAttribute('checked', '');

      const toggleSpan = document.createElement('span');

      toggleLabel.appendChild(toggleInput);
      toggleLabel.appendChild(toggleSpan);

      cardHeader.appendChild(toggleLabel);

      card.appendChild(cardHeader);

      const cardBody = document.createElement('div');
      cardBody.classList.add('card-body');
      cardBody.innerHTML = `<p>${data[i].content}</p>`;
      card.appendChild(cardBody);

      const cardFooter = document.createElement('div');
      cardFooter.classList.add('card-footer');
      cardFooter.innerHTML = `<a href="#">Contribute</a>`;
      card.appendChild(cardFooter);

      cardGrid.appendChild(card);
    }
  }

  // Function to render pagination links
  function renderPagination(totalPages) {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = ''; // Clear previous pagination links

    for (let i = 1; i <= totalPages; i++) {
      const pageItem = document.createElement('li');
      pageItem.classList.add('page-item');

      const pageLink = document.createElement('a');
      pageLink.classList.add('page-link');
      pageLink.href = '#';
      pageLink.textContent = i;

      pageLink.addEventListener('click', function () {
        renderCards(i, 3, cardData); // Set the pageSize to 9
      });

      pageItem.appendChild(pageLink);
      pagination.appendChild(pageItem);
    }
  }

  // Initial rendering
  const pageSize = 9; // Number of cards per page
  const totalPages = Math.ceil(<?php echo count($cardData); ?> / pageSize); // Use PHP count function to get the array length

  renderCards(1, pageSize, <?php echo json_encode($cardData); ?>);
  renderPagination(totalPages);
</script>


</body>
<style>
  @import url("https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

  :root {
    --c-text-primary: #282a32;
    --c-text-secondary: #686b87;
    --c-text-action: #404089;
    --c-accent-primary: #434ce8;
    --c-border-primary: #eff1f6;
    --c-background-primary: #ffffff;
    --c-background-secondary: #fdfcff;
    --c-background-tertiary: #ecf3fe;
    --c-background-quaternary: #e9ecf4;
  }

  body {
    line-height: 1.5;
    min-height: 100vh;
    font-family: "Be Vietnam Pro", sans-serif;
    background-color: var(--c-background-secondary);
    color: var(--c-text-primary);
  }

  img {
    display: block;
    max-width: 100%;
  }

  :focus {
    outline: 0;
  }

  .responsive-wrapper {
    width: 90%;
    max-width: 1280px;
    margin-left: auto;
    margin-right: auto;
  }

  .header {
    display: flex;
    align-items: center;
    height: 80px;
    border-bottom: 1px solid var(--c-border-primary);
    background-color: var(--c-background-primary);
  }

  .header-content {
    display: flex;
    align-items: center;

    &>a {
      display: none;
    }

    @media (max-width: 1200px) {
      justify-content: space-between;

      &>a {
        display: inline-flex;
      }
    }
  }

  .header-logo {
    margin-right: 2.5rem;

    a {
      display: flex;
      align-items: center;

      div {
        // outline: 2px solid;
        flex-shrink: 0;
        position: relative;

        &:after {
          display: block;
          content: "";
          position: absolute;
          left: 0;
          top: auto;
          right: 0;
          bottom: 0;
          overflow: hidden;
          height: 50%;
          border-bottom-left-radius: 8px;
          border-bottom-right-radius: 8px;
          background-color: rgba(#fff, 0.2);
          backdrop-filter: blur(4px);
        }
      }
    }
  }

  .header-navigation {
    display: flex;
    flex-grow: 1;
    align-items: center;
    justify-content: space-between;

    @media (max-width: 1200px) {
      display: none;
    }
  }

  .header-navigation-links {
    display: flex;
    align-items: center;

    a {
      text-decoration: none;
      color: var(--c-text-action);
      font-weight: 500;
      transition: 0.15s ease;

      &+* {
        margin-left: 1.5rem;
      }

      &:hover,
      &:focus {
        color: var(--c-accent-primary);
      }
    }
  }

  .header-navigation-actions {
    display: flex;
    align-items: center;

    &>.avatar {
      margin-left: 0.75rem;
    }

    &>.icon-button+.icon-button {
      margin-left: 0.25rem;
    }

    &>.button+.icon-button {
      margin-left: 1rem;
    }
  }

  .button {
    font: inherit;
    color: inherit;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 1em;
    height: 40px;
    border-radius: 8px;
    line-height: 1;
    border: 2px solid var(--c-border-primary);
    color: var(--c-text-action);
    font-size: 0.875rem;
    transition: 0.15s ease;
    background-color: var(--c-background-primary);

    i {
      margin-right: 0.5rem;
      font-size: 1.25em;
    }

    span {
      font-weight: 500;
    }

    &:hover,
    &:focus {
      border-color: var(--c-accent-primary);
      color: var(--c-accent-primary);
    }
  }

  .icon-button {
    font: inherit;
    color: inherit;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 8px;
    color: var(--c-text-action);
    transition: 0.15s ease;

    i {
      font-size: 1.25em;
    }

    &:focus,
    &:hover {
      background-color: var(--c-background-tertiary);
      color: var(--c-accent-primary);
    }
  }

  .avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    overflow: hidden;
  }

  .main {
    padding-top: 3rem;
  }

  .main-header {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;

    h1 {
      font-size: 1.75rem;
      font-weight: 600;
      line-height: 1.25;

      @media (max-width: 550px) {
        margin-bottom: 1rem;
      }
    }
  }

  .search {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
    max-width: 340px;

    input {
      font: inherit;
      color: inherit;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0 1em 0 36px;
      height: 40px;
      border-radius: 8px;
      border: 2px solid var(--c-border-primary);
      color: var(--c-text-action);
      font-size: 0.875rem;
      transition: 0.15s ease;
      width: 100%;
      line-height: 1;

      &::placeholder {
        color: var(--c-text-action);
      }

      &:focus,
      &:hover {
        border-color: var(--c-accent-primary);
      }
    }

    button {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: 0;
      background-color: transparent;
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 1.25em;
      color: var(--c-text-action);
      padding: 0;
      height: 40px;
    }
  }

  .horizontal-tabs {
    margin-top: 1.5rem;
    display: flex;
    align-items: center;
    overflow-x: auto;

    @media (max-width: 1000px) {
      scrollbar-width: none;
      position: relative;

      &::-webkit-scrollbar {
        display: none;
      }
    }

    a {
      display: inline-flex;
      flex-shrink: 0;
      align-items: center;
      height: 48px;
      padding: 0 0.25rem;
      font-weight: 500;
      color: inherit;
      border-bottom: 3px solid transparent;
      text-decoration: none;
      transition: 0.15s ease;

      &:hover,
      &:focus,
      &.active {
        color: var(--c-accent-primary);
        border-bottom-color: var(--c-accent-primary);
      }

      &+* {
        margin-left: 1rem;
      }
    }
  }

  .content-header {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    padding-top: 3rem;
    margin-top: -1px;
    border-top: 1px solid var(--c-border-primary);
  }

  .content-header-intro {
    h2 {
      font-size: 1.8rem;
      font-weight: 1200;
    }

    p {
      color: var(--c-text-secondary);
      margin-top: 0.25rem;
      font-size: 0.875rem;
      margin-bottom: 1rem;
    }
  }

  .content-header-actions {
    a:first-child {
      @media (min-width: 800px) {
        display: none;
      }
    }
  }

  .content {
    border-top: 1px solid var(--c-border-primary);
    margin-top: 2rem;
    display: flex;
    align-items: flex-start;
  }

  .content-panel {
    display: none;
    max-width: 280px;
    width: 25%;
    padding: 2rem 1rem 2rem 0;
    margin-right: 3rem;

    @media (min-width: 800px) {
      display: block;
    }
  }

  .vertical-tabs {
    display: flex;
    flex-direction: column;

    a {
      display: flex;
      align-items: center;
      padding: 0.75em 1em;
      background-color: transparent;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 500;
      color: var(--c-text-action);
      transition: 0.15s ease;

      &:hover,
      &:focus,
      &.active {
        background-color: var(--c-background-tertiary);
        color: var(--c-accent-primary);
      }

      &+* {
        margin-top: 0.25rem;
      }
    }
  }

  .content-main {
    padding-top: 2rem;
    padding-bottom: 6rem;
    flex-grow: 1;
  }

  .card-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    column-gap: 1.5rem;
    row-gap: 1.5rem;

    @media (min-width: 600px) {
      grid-template-columns: repeat(2, 1fr);
    }

    @media (min-width: 1200px) {
      grid-template-columns: repeat(3, 1fr);
    }
  }

  .card {
    background-color: var(--c-background-primary);
    box-shadow: 0 3px 3px 0 rgba(#000, 0.05), 0 5px 15px 0 rgba(#000, 0.05);
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
  }

  .card-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 1.5rem 1.25rem 1rem 1.25rem;

    div {
      display: flex;
      align-items: center;

      span {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;

        img {
          // max-width: 85%;
          max-height: 100%;
        }
      }

      h3 {
        margin-left: 0.75rem;
        font-weight: 500;
      }
    }
  }

  .toggle {
    span {
      display: block;
      width: 40px;
      height: 24px;
      border-radius: 99em;
      background-color: var(--c-background-quaternary);
      box-shadow: inset 1px 1px 1px 0 rgba(#000, 0.05);
      position: relative;
      transition: 0.15s ease;

      &:before {
        content: "";
        display: block;
        position: absolute;
        left: 3px;
        top: 3px;
        height: 18px;
        width: 18px;
        background-color: var(--c-background-primary);
        border-radius: 50%;
        box-shadow: 0 1px 3px 0 rgba(#000, 0.15);
        transition: 0.15s ease;
      }
    }

    input {
      clip: rect(0 0 0 0);
      clip-path: inset(50%);
      height: 1px;
      overflow: hidden;
      position: absolute;
      white-space: nowrap;
      width: 1px;

      &:checked+span {
        background-color: var(--c-accent-primary);

        &:before {
          transform: translateX(calc(100% - 2px));
        }
      }

      &:focus+span {
        box-shadow: 0 0 0 4px var(--c-background-tertiary);
      }
    }
  }

  .card-body {
    padding: 1rem 1.25rem;
    font-size: 0.875rem;
  }

  .card-footer {
    margin-top: auto;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    border-top: 1px solid var(--c-border-primary);

    a {
      color: var(--c-text-action);
      text-decoration: none;
      font-weight: 500;
      font-size: 0.875rem;
    }
  }

  html {
    &::-webkit-scrollbar {
      width: 12px;
    }

    &::-webkit-scrollbar-thumb {
      background-color: var(--c-text-primary);
      border: 4px solid var(--c-background-primary);
      border-radius: 99em;
    }
  }
</style>

</html>