<?php
// Start the session
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "rgdhicgm_app";
$password = "app123";
$dbname = "rgdhicgm_app";

// Set the error reporting level to E_ALL
error_reporting(E_ALL);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables to store topic details
$topicId = $editedTopic = $editedAssignedTo = $editedTopicType = '';
$subtopic = $challengeDescription = $possibleCauses = $treatmentAndRemediations = '';
$preventionMeasures = $parentGuardianGuidance = '';
$technologyAndAssistiveTools = $communityAndSocialSupport = '';
$latestResearchAndDevelopment = $parentTestimonyOrProfessionalFeedbacks = '';
$successStories = $culturalAndLinguisticConsideration = $nutritionAndLifestyleChanges = '';
$emergencyProtocols = $sourceAndReferences = $professionalInsights = '';
$ageSpecificInformation = $legalAndEducationalRights = '';  // new columns

// Check if the topic_id is provided in the URL
if (isset($_GET['topic_id'])) {
    $topicId = $_GET['topic_id'];

    // Fetch topic details from the database
    $fetchSql = "SELECT * FROM topics WHERE id = ?";
    $stmt = $conn->prepare($fetchSql);
    $stmt->bind_param("i", $topicId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $editedTopic = $row["topic"];
        $editedAssignedTo = $row["assigned_to"];
        $editedTopicType = $row["type"];
        $subtopic = $row["subtopic"];
        $challengeDescription = $row["challenge_description"];
        $possibleCauses = $row["possible_causes"];
        $treatmentAndRemediations = $row["treatment_and_remediations"];
        $preventionMeasures = $row["prevention_measures"];
        $parentGuardianGuidance = $row["parent_guardian_guidance"];
        $technologyAndAssistiveTools = $row["technology_and_assistive_tools"];
        $communityAndSocialSupport = $row["community_and_social_support"];
        $latestResearchAndDevelopment = $row["latest_research_and_development"];
        $parentTestimonyOrProfessionalFeedbacks = $row["parent_testimony_or_professional_feedbacks"];
        $successStories = $row["success_stories"];
        $culturalAndLinguisticConsideration = $row["cultural_and_linguistic_consideration"];
        $nutritionAndLifestyleChanges = $row["nutrition_and_lifestyle_changes"];
        $emergencyProtocols = $row["emergency_protocols"];
        $sourceAndReferences = $row["source_and_references"];
        $professionalInsights = $row["professional_insights"];
        $ageSpecificInformation = $row["age_specific_information"];
        $legalAndEducationalRights = $row["legal_and_educational_rights"];
    } else {
        echo "Topic not found.";
    }
}

// Check if the form is submitted for updating
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $topicId = $_POST['topic_id'];
    $editedTopic = $_POST["edited_topic"];
    $editedAssignedTo = $_POST["edited_assigned_to"];
    $editedTopicType = $_POST["edited_topic_type"];
    $subtopic = $_POST["subtopic"];
    $challengeDescription = $_POST["challenge_description"];
    $possibleCauses = $_POST["possible_causes"];
    $treatmentAndRemediations = $_POST["treatment_and_remediations"];
    $preventionMeasures = $_POST["prevention_measures"];
    $parentGuardianGuidance = $_POST["parent_guardian_guidance"];
    $technologyAndAssistiveTools = $_POST["technology_and_assistive_tools"];
    $communityAndSocialSupport = $_POST["community_and_social_support"];
    $latestResearchAndDevelopment = $_POST["latest_research_and_development"];
    $parentTestimonyOrProfessionalFeedbacks = $_POST["parent_testimony_or_professional_feedbacks"];
    $successStories = $_POST["success_stories"];
    $culturalAndLinguisticConsideration = $_POST["cultural_and_linguistic_consideration"];
    $nutritionAndLifestyleChanges = $_POST["nutrition_and_lifestyle_changes"];
    $emergencyProtocols = $_POST["emergency_protocols"];
    $sourceAndReferences = $_POST["source_and_references"];
    $professionalInsights = $_POST["professional_insights"];
    $ageSpecificInformation = $_POST["age_specific_information"];
    $legalAndEducationalRights = $_POST["legal_and_educational_rights"];

// Update the edited topic in the database using prepared statements
$updateSql = "UPDATE topics 
              SET topic = ?, assigned_to = ?, type = ?, subtopic = ?, challenge_description = ?, 
              possible_causes = ?, treatment_and_remediations = ?, prevention_measures = ?, 
              parent_guardian_guidance = ?, technology_and_assistive_tools = ?, 
              community_and_social_support = ?, latest_research_and_development = ?, 
              parent_testimony_or_professional_feedbacks = ?, success_stories = ?, 
              cultural_and_linguistic_consideration = ?, nutrition_and_lifestyle_changes = ?, 
              emergency_protocols = ?, source_and_references = ?, professional_insights = ?, 
              age_specific_information = ?, legal_and_educational_rights = ?
              WHERE id = ?";

$stmt = $conn->prepare($updateSql);

// Use 's' for string placeholders and 'i' for integer placeholders
$stmt->bind_param(
    "sssssssssssssssssssssi",
    $editedTopic, $editedAssignedTo, $editedTopicType, $subtopic, $challengeDescription,
    $possibleCauses, $treatmentAndRemediations, $preventionMeasures, $parentGuardianGuidance,
    $technologyAndAssistiveTools, $communityAndSocialSupport, $latestResearchAndDevelopment,
    $parentTestimonyOrProfessionalFeedbacks, $successStories, $culturalAndLinguisticConsideration,
    $nutritionAndLifestyleChanges, $emergencyProtocols, $sourceAndReferences, $professionalInsights,
    $ageSpecificInformation, $legalAndEducationalRights, $topicId
);

    if ($stmt->execute()) {
        // Display the "Saved" message
        echo '<p class="alert alert-success" style="font-size: 24px; font-weight: bold;">Saved!</p>';

        // Wait for 2 seconds and then redirect to main.php
        echo '<script>
                setTimeout(function() {
                    window.location.href = "main.php?id=' . $topicId . '&topic=' . $editedTopic . '&assigned_to=' . $editedAssignedTo . '&type=' . $editedTopicType . '";
                }, 2000);
              </script>';
    } else {
        echo '<p class="alert alert-danger">Error updating topic: ' . $stmt->error . '</p>';
    }
    $stmt->close();
}
?>

<!-- HTML form for editing a topic -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Topic</title>
    <!-- Add Bootstrap CSS link -->
    <!-- Include CKEditor script -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<body>

<div class="container mt-5">

 <form id="editForm" method='post' action='main.php?q=EditData&topic_id=<?php echo $topicId; ?>' onsubmit='submitForm();'>
        <!-- Include the topic_id as a hidden input field -->
        <input type="hidden" name="topic_id" value="<?php echo $topicId; ?>">
        <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center"><hr>
            <a href="main.php" class="btn btn-primary">Go Back to Home</a>
        </div>
      <div class="d-flex justify-content-between align-items-center">
            <h4 name='edited_topic' class="form-label">Topic: <b><?php echo $editedTopic; ?></b></h4>
                    <input type="hidden" name="edited_topic" value="<?php echo $editedTopic; ?>" readonly>

        </div><hr>
        <!-- Hide "Assigned To" field -->
        <div class="mb-3" style="display: none;">
            <label for='edited_assigned_to' class="form-label"><b>Assigned To:</b></label>
            <input type='text' class="form-control" name='edited_assigned_to' value='<?php echo $editedAssignedTo; ?>' readonly>
        </div>
        <div class="mb-3">
            <label for='edited_topic_type' class="form-label"><b>Topic Type:</b></label>
            <input type='text' class="form-control" name='edited_topic_type' value='<?php echo $editedTopicType; ?>' readonly>
        </div>
        <!-- Make "Subtopic" read-only -->
        <div class="mb-3">
            <label for='subtopic' class="form-label"><b>Subtopic:</b></label>
            <input type='text' class="form-control" name='subtopic' value='<?php echo $subtopic; ?>' readonly>
        </div>
                <!-- Change "Challenge Description" to textarea -->
        <div class="mb-3">
                   <i class="bi bi-exclamation-triangle-fill text-warning"></i>
 <label for='challenge_description' class="form-label"><b>Challenge Description:</b></label>
                        <textarea name='challenge_description' class="form-control" id='editor' rows="4"><?php echo $challengeDescription; ?></textarea>

        </div>
        <div class="mb-3">
        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='possible_causes' class="form-label"><b>Possible Causes:</b></label>
            <textarea class="form-control" name='possible_causes'  id='editor1' rows="4"><?php echo $possibleCauses; ?></textarea>
        </div>
        <div class="mb-3">
        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='treatment_and_remediations' class="form-label"><b>Solution, Treatment and Remediations:</b></label>
            <textarea class="form-control" name='treatment_and_remediations' id='editor2'  rows="4"><?php echo $treatmentAndRemediations; ?></textarea>
        </div>
        <!-- Add "Prevention Measures" field -->
        <div class="mb-3">
        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='prevention_measures' class="form-label"><b>Prevention Measures:</b></label>
            <textarea class="form-control" name='prevention_measures' id='editor3'  rows="4"><?php echo $preventionMeasures; ?></textarea>
        </div>
        <!-- Add "Parent/Guardian Guidance" field -->
        <div class="mb-3">
        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='parent_guardian_guidance' class="form-label"><b>Parent/Guardian Guidance:</b></label>
            <textarea class="form-control" name='parent_guardian_guidance' id='editor4'  rows="4"><?php echo $parentGuardianGuidance; ?></textarea>
        </div>
        <!-- Add "Technology and Assistive Tools" field -->
        <div class="mb-3">
        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='technology_and_assistive_tools' class="form-label"><b>Technology and Assistive Tools:</b></label>
            <textarea class="form-control" name='technology_and_assistive_tools'  id='editor5' rows="4"><?php echo $technologyAndAssistiveTools; ?></textarea>
        </div>
        <!-- Add "Community and Social Support" field -->
        <div class="mb-3">
        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='community_and_social_support' class="form-label"><b>Community and Social Support:</b></label>
            <textarea class="form-control" name='community_and_social_support' id='editor6'  rows="4"><?php echo $communityAndSocialSupport; ?></textarea>
        </div>
        <div class="mb-3">
        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='community_and_social_support' class="form-label"><b>Latest Research & Development:</b></label>
            <textarea class="form-control" name='latest_research_and_development' id='editor7'  rows="4"><?php echo $latestResearchAndDevelopment; ?></textarea>
        </div>
        <!-- Add "Parent Testimony or Professional Feedbacks" field -->
        <div class="mb-3">
        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='parent_testimony_or_professional_feedbacks' class="form-label"><b>Parent Testimony or Professional Feedbacks:</b></label>
            <textarea class="form-control" name='parent_testimony_or_professional_feedbacks'  id='editor8' rows="4"><?php echo $parentTestimonyOrProfessionalFeedbacks; ?></textarea>
        </div>
        <!-- Add "Success Stories" field -->
        <div class="mb-3">
        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='success_stories' class="form-label"><b>Success Stories:</b></label>
            <textarea class="form-control" name='success_stories'  id='editor9' rows="4"><?php echo $successStories; ?></textarea>
        </div>
        <!-- Add "Cultural and Linguistic Consideration" field -->
        <div class="mb-3">
        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='cultural_and_linguistic_consideration' class="form-label"><b>Cultural and Linguistic Consideration:</b></label>
            <textarea class="form-control"  id='editor10' name='cultural_and_linguistic_consideration' rows="4"><?php echo $culturalAndLinguisticConsideration; ?></textarea>
        </div>
        <!-- Add "Nutrition and Lifestyle Changes" field -->
        <div class="mb-3">
        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='nutrition_and_lifestyle_changes' class="form-label"><b>Nutrition and Lifestyle Changes:</b></label>
            <textarea class="form-control"  id='editor11' name='nutrition_and_lifestyle_changes' rows="4"><?php echo $nutritionAndLifestyleChanges; ?></textarea>
        </div>
        <!-- Add "Emergency Protocols" field -->
        <div class="mb-3">
        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='emergency_protocols' class="form-label"><b>Emergency Protocols:</b></label>
            <textarea class="form-control" id='editor12'  name='emergency_protocols' rows="4"><?php echo $emergencyProtocols; ?></textarea>
        </div>
        <!-- Add "Source and References" field -->
        <div class="mb-3">
        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='source_and_references' class="form-label"><b>Source and References:</b></label>
            <textarea class="form-control"  id='editor13' name='source_and_references' rows="4"><?php echo $sourceAndReferences; ?></textarea>
        </div>
        <!-- Add "Professional Insights" field -->
        <div class="mb-3">
        <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='professional_insights' class="form-label"><b>Professional Insights:</b></label>
            <textarea class="form-control"  id='editor14' name='professional_insights' rows="4"><?php echo $professionalInsights; ?></textarea>
        </div>
        <!-- Add "Age-Specific Information" field -->
        <div class="mb-3">
            <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='age_specific_information' class="form-label"><b>Age-Specific Information:</b></label>
            <textarea class="form-control" id='editor15'  name='age_specific_information' rows="4"><?php echo $ageSpecificInformation; ?></textarea>
        </div>
        <!-- Add "Legal and Educational Rights" field -->
        <div class="mb-3">
            <i class="bi bi-exclamation-triangle-fill text-warning"></i>
            <label for='legal_and_educational_rights' class="form-label"><b>Legal and Educational Rights:</b></label>
            <textarea class="form-control"  id='editor16' name='legal_and_educational_rights' rows="4"><?php echo $legalAndEducationalRights; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Topic</button>
    </form>
</div>
<script>
    CKEDITOR.replace('editor', {
        spellchecker_language: 'en'
    });
    CKEDITOR.replace('editor1', {
        spellchecker_language: 'en'
    });

    CKEDITOR.replace('editor2', {
        spellchecker_language: 'en'
    });

    CKEDITOR.replace('editor3', {
        spellchecker_language: 'en'
    });

    CKEDITOR.replace('editor4', {
        spellchecker_language: 'en'
    });

    CKEDITOR.replace('editor5', {
        spellchecker_language: 'en'
    });

    CKEDITOR.replace('editor6', {
        spellchecker_language: 'en'
    });

    CKEDITOR.replace('editor7', {
        spellchecker_language: 'en'
    });

    CKEDITOR.replace('editor8', {
        spellchecker_language: 'en'
    });

    CKEDITOR.replace('editor9', {
        spellchecker_language: 'en'
    });

    CKEDITOR.replace('editor10', {
        spellchecker_language: 'en'
    });

    CKEDITOR.replace('editor11', {
        spellchecker_language: 'en'
    });

    CKEDITOR.replace('editor12', {
        spellchecker_language: 'en'
    });

    CKEDITOR.replace('editor13', {
        spellchecker_language: 'en'
    });

    CKEDITOR.replace('editor14', {
        spellchecker_language: 'en'
    });

    CKEDITOR.replace('editor15', {
        spellchecker_language: 'en'
    });
    CKEDITOR.replace('editor16', {
        spellchecker_language: 'en'
    });

</script>


</body>
</html>
