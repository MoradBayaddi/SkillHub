// // Sample job data (you would get this from your server in a real app)
// const jobData = [
//     { 
//         title: 'electrician', 
//         description: 'idunt blanditiis quo mollitia rem perferendis porro ipsum alias. ', 
//         location: 'New York, NY',
//         image: 'job-image-1.jpg',
//         detailLink: '#'
//     },
//     { 
//         title: 'driver', 
//         description: 'idunt blanditiis quo mollitia rem perferendis porro ipsum alias. ', 
//         location: 'New York, NY',
//         image: 'job-image-1.jpg',
//         detailLink: '#'
//     },
//     { 
//         title: 'plumber', 
//         description: 'idunt blanditiis quo mollitia rem perferendis porro ipsum alias. ', 
//         location: 'New York, NY',
//         image: 'job-image-1.jpg',
//         detailLink: '#'
//     },
//     { 
//         title: 'plumber', 
//         description: 'idunt blanditiis quo mollitia rem perferendis porro ipsum alias. ', 
//         location: 'New York, NY',
//         image: 'job-image-1.jpg',
//         detailLink: '#'
//     },
//     { 
//         title: 'driver', 
//         description: 'idunt blanditiis quo mollitia rem perferendis porro ipsum alias. ', 
//         location: 'New York, NY',
//         image: 'job-image-1.jpg',
//         detailLink: '#'
//     },
//     { 
//         title: 'constructor', 
//         description: 'idunt blanditiis quo mollitia rem perferendis porro ipsum alias. ', 
//         location: 'marrakech',
//         image: 'job-image-1.jpg',
//         detailLink: '#'
//     },
//     { 
//         title: 'constructor', 
//         description: 'idunt blanditiis quo mollitia rem perferendis porro ipsum alias. ', 
//         location: 'marrakech',
//         image: 'job-image-1.jpg',
//         detailLink: '#'
//     },
//     { 
//         title: 'constructor', 
//         description: 'idunt blanditiis quo mollitia rem perferendis porro ipsum alias. ', 
//         location: 'marrakech',
//         image: 'job-image-1.jpg',
//         detailLink: '#'
//     }, 
//     { 
//         title: 'constructor', 
//         description: 'idunt blanditiis quo mollitia rem perferendis porro ipsum alias. ', 
//         location: 'marrakech',
//         image: 'job-image-1.jpg',
//         detailLink: '#'
//     },
//     { 
//         title: 'electrician', 
//         description: 'idunt blanditiis quo mollitia rem perferendis porro ipsum alias. ', 
//         location: 'New York, NY',
//         image: 'job-image-1.jpg',
//         detailLink: '#'
//     },
//     { 
//         title: 'driver', 
//         description: 'idunt blanditiis quo mollitia rem perferendis porro ipsum alias. ', 
//         location: 'New York, NY',
//         image: 'job-image-1.jpg',
//         detailLink: '#'
//     },
//     { 
//         title: 'driver', 
//         description: 'idunt blanditiis quo mollitia rem perferendis porro ipsum alias. ', 
//         location: 'New York, NY',
//         image: 'job-image-1.jpg',
//         detailLink: '#'
//     },
//     { 
//         title: 'plumber', 
//         description: 'idunt blanditiis quo mollitia rem perferendis porro ipsum alias. ', 
//         location: 'New York, NY',
//         image: 'job-image-1.jpg',
//         detailLink: '#'
//     },
   
//     // Add more jobs here
//     // ... up to at least 30 or more
// ];

// let currentIndex = 0;
// const jobsPerPage = 12;

// // Function to render job cards
// function renderJobCards(start, count) {
//     const container = document.getElementById('job-cards');

    
//     for (let i = start; i < start + count && i < jobData.length; i++) {
//         const job = jobData[i];
//         const card = `
//             <div class="col-lg-4 col-md-6 mb-4">
//                 <div class="card h-100">
//                     <!-- <img src="${job.image}" class="card-img-top" alt="${job.title}"> -->
                    
//                     <div class="card-body">
//                         <h5 class="card-title text-primary">${job.title}</h5>
//                         <p class="card-text">${job.description}</p>
//                         <p class="card-location text-accent"><strong>${job.location}</strong> </p>
                        
//                     </div>
//                     <div class="card-footer d-flex">
//                         <a href="#" class="btn btn-sec">Apply Now</a>
//                         <a href="${job.detailLink}" class="btn btn-link">More Details</a>
//                     </div>
//                 </div>
//             </div>
//         `;
//         container.insertAdjacentHTML('beforeend', card);
//     }
// }

// // Initial render
// renderJobCards(currentIndex, jobsPerPage);
// currentIndex += jobsPerPage;

// document.addEventListener('DOMContentLoaded', function() {
//     const cardCount = document.querySelectorAll('.card').length;
//     const loadBtn = document.getElementById('load-more');

//     if (cardCount < 12) {
//         loadBtn.style.display = 'none';
//     }
// });
// // Show more button click event
// document.getElementById('load-more').addEventListener('click', function () {
//     renderJobCards(currentIndex, jobsPerPage);
//     currentIndex += jobsPerPage;
    
//     // Hide the button if all jobs are loaded
//     if (currentIndex >= jobData.length) {
//         this.style.display = 'none';
//     }
// });

document.getElementById('share-button').addEventListener('click', function() {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            url: window.location.href
        }).then(() => {
            console.log('Thanks for sharing!');
        }).catch(console.error);
    } else {
        // Fallback for browsers that don't support the Web Share API
        const dummy = document.createElement('textarea');
        document.body.appendChild(dummy);
        dummy.value = window.location.href;
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);
        alert('URL copied to clipboard!');
    }
});





