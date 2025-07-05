 // Mobile menu toggle
 const mobileMenuBtn = document.getElementById('mobile-menu-btn');
 const mobileMenu = document.getElementById('mobile-menu');
 
 mobileMenuBtn.addEventListener('click', () => {
     mobileMenu.classList.toggle('hidden');
 });


 // Counter animation
 function animateCounters() {
     const counters = document.querySelectorAll('.counter');
     
     counters.forEach(counter => {
         const target = parseFloat(counter.getAttribute('data-target'));
         const increment = target / 100;
         let current = 0;
         
         const updateCounter = () => {
             if (current < target) {
                 current += increment;
                 if (target === 99.9) {
                     counter.textContent = current.toFixed(1);
                 } else if (target === 2.5) {
                     counter.textContent = current.toFixed(1);
                 } else {
                     counter.textContent = Math.ceil(current);
                 }
                 setTimeout(updateCounter, 50);
             } else {
                 if (target === 99.9) {
                     counter.textContent = '99.9';
                 } else if (target === 2.5) {
                     counter.textContent = '2.5';
                 } else {
                     counter.textContent = target;
                 }
             }
         };
         
         updateCounter();
     });
 }

 // Intersection Observer for counter animation
 const statsSection = document.getElementById('stats');
 const observer = new IntersectionObserver((entries) => {
     entries.forEach(entry => {
         if (entry.isIntersecting) {
             animateCounters();
             observer.unobserve(entry.target);
         }
     });
 });

 observer.observe(statsSection);

 // Smooth scrolling for navigation links
 document.querySelectorAll('a[href^="#"]').forEach(anchor => {
     anchor.addEventListener('click', function (e) {
         e.preventDefault();
         
         const targetId = this.getAttribute('href');
         const targetSection = document.querySelector(targetId);
         
         if (targetSection) {
             const offsetTop = targetSection.offsetTop - 80;
             window.scrollTo({
                 top: offsetTop,
                 behavior: 'smooth'
             });
             
             // Close mobile menu if open
             mobileMenu.classList.add('hidden');
         }
     });
 });

// Add scroll effect to navigation
 window.addEventListener('scroll', () => {
     const nav = document.querySelector('nav');
     if (window.scrollY > 50) {
         nav.classList.add('shadow-lg');
     } else {
         nav.classList.remove('shadow-lg');
     }
 });

 // Add parallax effect to hero section
 // window.addEventListener('scroll', () => {
 //     const scrolled = window.pageYOffset;
 //     const parallax = document.querySelector('#home');
 //     const speed = scrolled * 0.5;
 //     parallax.style.transform = `translateY(${speed}px)`;
 // });

 // Add hover effects to feature cards
 const featureCards = document.querySelectorAll('#features .group');
 featureCards.forEach(card => {
     card.addEventListener('mouseenter', () => {
         card.style.transform = 'translateY(-10px)';
     });
     
     card.addEventListener('mouseleave', () => {
         card.style.transform = 'translateY(0)';
     });
 });

 // Dynamic file icon generation
 function createFloatingIcon() {
     const icons = [
         '<svg class="w-full h-full text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18h12V6l-4-4H4v16zm9-13v4h4l-4-4z"/></svg>',
         '<svg class="w-full h-full text-green-400" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm8 6a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
         '<svg class="w-full h-full text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path d="M4 5a2 2 0 012-2v1a2 2 0 002 2h8a2 2 0 002-2V3a2 2 0 012 2v6h-4.586l1.293-1.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L14.586 13H19v3a2 2 0 01-2 2H3a2 2 0 01-2-2V5z"/></svg>',
         '<svg class="w-full h-full text-purple-400" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>',
         '<svg class="w-full h-full text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/></svg>'
     ];
     
     setInterval(() => {
         const uploadSection = document.getElementById('upload');
         const container = uploadSection.querySelector('.relative');
         
         // Remove old icons
         const oldIcons = container.querySelectorAll('.dynamic-icon');
         if (oldIcons.length > 8) {
             oldIcons[0].remove();
         }
         
         // Create new icon
         const icon = document.createElement('div');
         icon.className = 'file-icon dynamic-icon';
         icon.style.cssText = `
             width: 30px;
             height: 30px;
             position: absolute;
             opacity: 0.6;
             animation: floatRandom 10s infinite ease-in-out;
             top: ${Math.random() * 80}%;
             left: ${Math.random() * 80}%;
             animation-delay: ${Math.random() * -5}s;
         `;
         icon.innerHTML = icons[Math.floor(Math.random() * icons.length)];
         
         container.appendChild(icon);
         
         // Auto remove after animation
         setTimeout(() => {
             if (icon.parentNode) {
                 icon.remove();
             }
         }, 10000);
     }, 2000);
 }

 // Initialize dynamic icons
 createFloatingIcon();

 // Add loading animation
 window.addEventListener('load', () => {
     document.body.classList.add('loaded');
 });

 // Add typing effect to hero text
 function typeWriter(element, text, speed = 100) {
     let i = 0;
     element.innerHTML = '';
     
     function type() {
         if (i < text.length) {
             element.innerHTML += text.charAt(i);
             i++;
             setTimeout(type, speed);
         }
     }
     
     type();
 }

 // Initialize on page load
 document.addEventListener('DOMContentLoaded', () => {
     // Add fade-in animation to sections
     const sections = document.querySelectorAll('section');
     const fadeObserver = new IntersectionObserver((entries) => {
         entries.forEach(entry => {
             if (entry.isIntersecting) {
                 entry.target.style.opacity = '1';
                 entry.target.style.transform = 'translateY(0)';
             }
         });
     });

     sections.forEach(section => {
         section.style.opacity = '0';
         section.style.transform = 'translateY(50px)';
         section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
         fadeObserver.observe(section);
     });
 });