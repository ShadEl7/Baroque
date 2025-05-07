document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('job-post-form');
    const jobsContainer = document.getElementById('jobsContainer');
    const applicationsContainer = document.getElementById('applicationsContainer');

    async function fetchJobs() {
        const res = await fetch('/api/employer/jobs');
        const jobs = await res.json();
        jobsContainer.innerHTML = '';
        jobs.forEach(job => {
            const jobDiv = document.createElement('div');
            jobDiv.classList.add('job-item');
            jobDiv.innerHTML = `
                <h4>${job.title} - ${job.location}</h4>
                <p>${job.description}</p>
                <p><strong>Type:</strong> ${job.type}</p>
                <div class="job-actions">
                    <button onclick="editJob('${job._id}')">Edit</button>
                    <button onclick="deleteJob('${job._id}')">Delete</button>
                </div>
            `;
            jobsContainer.appendChild(jobDiv);
        });
    }

    async function fetchApplications() {
        const res = await fetch('/api/employer/applications');
        const applications = await res.json();
        applicationsContainer.innerHTML = '';
        applications.forEach(app => {
            const appDiv = document.createElement('div');
            appDiv.classList.add('applicant-item');
            appDiv.innerHTML = `
                <h4>${app.name} applied for ${app.jobTitle}</h4>
                <p><strong>Email:</strong> ${app.email}</p>
                <a href="/api/resumes/${app.resume}" download>Download Resume</a>
            `;
            applicationsContainer.appendChild(appDiv);
        });
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const jobData = {
            title: document.getElementById('jobTitle').value,
            location: document.getElementById('location').value,
            description: document.getElementById('description').value,
            type: document.getElementById('type').value
        };

        const res = await fetch('/api/employer/post-job', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(jobData)
        });

        if (res.ok) {
            form.reset();
            fetchJobs();
        }
    });

    window.deleteJob = async (id) => {
        if (confirm('Are you sure you want to delete this job?')) {
            await fetch(`/api/employer/job/${id}`, { method: 'DELETE' });
            fetchJobs();
        }
    };

    window.editJob = async (id) => {
        const newTitle = prompt("Enter new job title:");
        const newDesc = prompt("Enter new job description:");
        if (newTitle && newDesc) {
            await fetch(`/api/employer/job/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ title: newTitle, description: newDesc })
            });
            fetchJobs();
        }
    };

    fetchJobs();
    fetchApplications();
});
