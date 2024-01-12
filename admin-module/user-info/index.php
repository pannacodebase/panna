<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        form {
            max-width: 400px;
            margin: auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        select,
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
        }

        button {
            background-color: #013289;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <h2 id="dg" style="color:#013289;margin-left:0px;text-align:center"> User Details </h2> <hr>
    <form action="" method="post">
        <label for="userType">I am:</label>
        <select name="userType" id="userType">
            <option value="autisticVoice">Autistic Voice</option>
            <option value="parent">Parent</option>
            <option value="caregiver">Caregiver</option>
            <option value="therapist">Therapist</option>
            <option value="other">Other</option>
        </select>

        <label for="location">My location is:</label>
        <input type="text" name="location" id="location" placeholder="Detecting location..." required readonly>

        <label for="city">City:</label>
        <input type="text" name="city" id="city" readonly>

        <label for="country">Country:</label>
        <input type="text" name="country" id="country" readonly>

        <div id="kidsSection" style="display: none;">
            <label for="numOfKids">Kids who are neurodivergent:</label>
            <select name="numOfKids" id="numOfKids">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="more">More</option>
            </select>
        </div>

        <label for="influencer">Would you like to be an influencer?</label>
        <select name="influencer" id="influencer">
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>

        <div id="influencerDetails" style="display: none;">
            <label for="hoursContributed">Hours you can contribute:</label>
            <input type="text" name="hoursContributed" id="hoursContributed">

            <label for="areaOfExpertise">Area of expertise:</label>
            <input type="text" name="areaOfExpertise" id="areaOfExpertise">
        </div>

        <button type="submit">Save</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const userTypeSelect = document.getElementById("userType");
            const locationInput = document.getElementById("location");
            const cityInput = document.getElementById("city");
            const countryInput = document.getElementById("country");
            const kidsSection = document.getElementById("kidsSection");
            const influencerSelect = document.getElementById("influencer");
            const influencerDetails = document.getElementById("influencerDetails");

            function getLocationDetails(latitude, longitude) {
                const apiUrl = `https://geocode.maps.co/reverse?lat=${latitude}&lon=${longitude}&api_key=659cb8cfcabc7581877479ltv722baa`;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        const city = data.address.city || data.address.town || data.address.village;
                        const country = data.address.country;
                        const address = data.display_name;
                        locationInput.value = `${latitude}, ${longitude}`;
                        cityInput.value = city || 'City not available';
                        countryInput.value = country || 'Country not available';
                    })
                    .catch(error => {
                        console.error(error);
                        locationInput.value = "Location not available";
                    });
            }

            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const { latitude, longitude } = position.coords;
                            getLocationDetails(latitude, longitude);
                        },
                        (error) => {
                            console.error(error.message);
                            locationInput.value = "Location not available";
                        }
                    );
                } else {
                    locationInput.value = "Geolocation is not supported by this browser.";
                }
            }

            getLocation();

            userTypeSelect.addEventListener("change", function () {
                if (this.value === "parent") {
                    kidsSection.style.display = "block";
                } else {
                    kidsSection.style.display = "none";
                }
            });

            influencerSelect.addEventListener("change", function () {
                if (this.value === "yes") {
                    influencerDetails.style.display = "block";
                } else {
                    influencerDetails.style.display = "none";
                }
            });
        });
    </script>
</body>

</html>
