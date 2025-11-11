document.addEventListener("DOMContentLoaded", function () {
					const slides = document.querySelector(".slides");
					const slideWidth = document.querySelector(".testimonial-card").offsetWidth;
					const totalSlides = document.querySelectorAll(".testimonial-card").length;
					let currentIndex = 0;
					let autoSlide;
				
					function nextSlide() {
						currentIndex++;
						if (currentIndex >= totalSlides) {
							currentIndex = 0; // Reset to first slide
						}
						updateSlidePosition();
					}
				
					function prevSlide() {
						currentIndex--;
						if (currentIndex < 0) {
							currentIndex = totalSlides - 1; // Move to last slide
						}
						updateSlidePosition();
					}
				
					function updateSlidePosition() {
						slides.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
					}
				
					function startAutoSlide() {
						autoSlide = setInterval(nextSlide, 3000); // Auto-slide every 3 seconds
					}
				
					function stopAutoSlide() {
						clearInterval(autoSlide);
					}
				
					// Start auto-slide
					startAutoSlide();
				
					// Pause on hover
					slides.addEventListener("mouseenter", stopAutoSlide);
					slides.addEventListener("mouseleave", startAutoSlide);
				
					// Add manual controls
					document.querySelector(".prev").addEventListener("click", prevSlide);
					document.querySelector(".next").addEventListener("click", nextSlide);
				});
				
				document.addEventListener("DOMContentLoaded", function () {
					const slides = document.querySelector(".slides");
					const slideWidth = document.querySelector(".testimonial-card").offsetWidth;
					const totalSlides = document.querySelectorAll(".testimonial-card").length;
					let currentIndex = 0;
					let autoSlide;
				
					function nextSlide() {
						currentIndex++;
						if (currentIndex >= totalSlides) {
							currentIndex = 0; // Reset to first slide
						}
						updateSlidePosition();
					}
				
					function prevSlide() {
						currentIndex--;
						if (currentIndex < 0) {
							currentIndex = totalSlides - 1; // Move to last slide
						}
						updateSlidePosition();
					}
				
					function updateSlidePosition() {
						slides.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
					}
				
					function startAutoSlide() {
						autoSlide = setInterval(nextSlide, 3000); // Auto-slide every 3 seconds
					}
				
					function stopAutoSlide() {
						clearInterval(autoSlide);
					}
				
					// Start auto-slide
					startAutoSlide();
				
					// Pause on hover
					slides.addEventListener("mouseenter", stopAutoSlide);
					slides.addEventListener("mouseleave", startAutoSlide);
				
					// Add manual controls
					document.querySelector(".prev").addEventListener("click", prevSlide);
					document.querySelector(".next").addEventListener("click", nextSlide);
				});
	function et_onesignal_scripts() {
							OneSignal.push(function() {
								OneSignal.sendTags({
								divi: 'yes'								});
							});
						}
							window.intercomSettings = {
							app_id: 'hrpt54hy',
														custom_launcher_selector: '.launch_intercom',
							widget: {
								activator: '#IntercomDefaultWidget'
							}
						};
						(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/hrpt54hy';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()
							window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag('consent', 'default', {
					'ad_storage': 'denied',
					'ad_user_data': 'denied',
					'ad_personalization': 'denied',
					'analytics_storage': 'denied',
					'wait_for_update': 500
				});
				window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag('js', new Date());
				gtag('config', 'AW-1006729916', {'anonymize_ip': true});
				gtag('set', 'ads_data_redaction', true);
				(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'90bf8f1b6c798032',t:'MTczODU1NTY5OC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();