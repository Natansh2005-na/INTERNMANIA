// scripts.js

// Handle dynamic filtering of internships without reloading the page
document.addEventListener("DOMContentLoaded", () => {
    const filterForm = document.querySelector("form");
    const internshipContainer = document.querySelector(".internships");

    // Add event listener for the filter form submission
    filterForm.addEventListener("submit", (e) => {
        e.preventDefault();

        // Get filter values
        const category = document.querySelector("#category").value;
        const city = document.querySelector("#city").value;

        // Make an AJAX request to fetch filtered internships
        fetch(`../php/search_internships.php?category=${category}&city=${city}`)
            .then((response) => response.json())
            .then((data) => {
                // Clear current internship listings
                internshipContainer.innerHTML = "<h2>Available Internships</h2>";

                // Display the results
                if (data.length > 0) {
                    data.forEach((internship) => {
                        internshipContainer.innerHTML += `
                            <div class="internship">
                                <h3>${internship.title}</h3>
                                <p><strong>Category:</strong> ${internship.category}</p>
                                <p><strong>City:</strong> ${internship.city}</p>
                                <p>${internship.description}</p>
                                <form action="../php/apply_internship.php" method="POST">
                                    <input type="hidden" name="internship_id" value="${internship.id}">
                                    <button type="submit">Apply</button>
                                </form>
                            </div>
                        `;
                    });
                } else {
                    internshipContainer.innerHTML += "<p>No internships found matching your criteria.</p>";
                }
            })
            .catch((error) => {
                console.error("Error fetching internships:", error);
                internshipContainer.innerHTML = "<p>Failed to load internships. Please try again later.</p>";
            });
    });
});

// Validate form inputs (registration and login pages)
function validateForm(formId) {
    const form = document.querySelector(`#${formId}`);
    const inputs = form.querySelectorAll("input");

    form.addEventListener("submit", (e) => {
        let isValid = true;

        inputs.forEach((input) => {
            if (input.value.trim() === "") {
                isValid = false;
                alert(`${input.name} cannot be empty!`);
                input.focus();
            }
        });

        if (!isValid) {
            e.preventDefault();
        }
    });
}

// Call validation function for specific forms
if (document.querySelector("#registerForm")) validateForm("registerForm");
if (document.querySelector("#loginForm")) validateForm("loginForm");
