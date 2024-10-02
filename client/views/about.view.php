<?php
view("partials/header.view.php");
view("partials/nav.view.php");
?>

<main>
    <div class="2xl:container 2xl:mx-auto lg:py-16 lg:px-20 md:py-12 md:px-6 py-9 px-4">
        <div class="flex flex-col lg:flex-row justify-between gap-8">
            <div class="w-full lg:w-5/12 flex flex-col justify-center">
                <h1 class="text-3xl lg:text-4xl font-bold leading-9 text-gray-800 dark:text-white pb-4">About Us</h1>
                <p class="font-normal text-base leading-6 text-gray-600 dark:text-white">
                    Welcome to Pollify, your go-to solution for secure and user-friendly online voting. We believe that everyone deserves a voice, and Pollify makes sure that every vote counts. Our mission is to help organizations, communities, and individuals create, manage, and participate in transparent and effective polls without the need for complex tools or deep technical knowledge.
                </p>
            </div>
            <div class="w-full lg:w-8/12">
                <img class="w-full h-full" src="https://i.ibb.co/FhgPJt8/Rectangle-116.png" alt="A group of People" />
            </div>
        </div>

        <div class="flex lg:flex-row flex-col justify-between gap-8 pt-12">
            <div class="w-full lg:w-5/12 flex flex-col justify-center">
                <h1 class="text-3xl lg:text-4xl font-bold leading-9 text-gray-800 dark:text-white pb-4">Our Story</h1>
                <p class="font-normal text-base leading-6 text-gray-600 dark:text-white">
                    Pollify was founded with a simple idea: to make the process of decision-making accessible to everyone. We noticed that traditional voting methods were often cumbersome, time-consuming, and inaccessible for many people. That’s when we decided to create Pollify — a modern platform that harnesses the power of technology to deliver a seamless and secure voting experience. Since our inception, we have been committed to improving democracy by making voting easy, transparent, and safe for everyone.
                </p>
            </div>
            <div class="w-full lg:w-8/12 lg:pt-8">
                <div class="grid md:grid-cols-4 sm:grid-cols-2 grid-cols-1 lg:gap-4 shadow-lg rounded-md">
                    <div class="p-4 pb-6 flex justify-center flex-col items-center">
                        <img class="md:block hidden" src="https://i.ibb.co/FYTKDG6/Rectangle-118-2.png" alt="Alexa featured Image" />
                        <img class="md:hidden block" src="https://i.ibb.co/zHjXqg4/Rectangle-118.png" alt="Alexa featured Image" />
                        <p class="font-medium text-xl leading-5 text-gray-800 dark:text-white mt-4">Alexa</p>
                        <p class="font-normal text-base leading-6 text-gray-600 dark:text-white">Alexa is our operations expert, ensuring that Pollify's services are always running smoothly and efficiently.</p>
                    </div>
                    <div class="p-4 pb-6 flex justify-center flex-col items-center">
                        <img class="md:block hidden" src="https://i.ibb.co/fGmxhVy/Rectangle-119.png" alt="Olivia featured Image" />
                        <img class="md:hidden block" src="https://i.ibb.co/NrWKJ1M/Rectangle-119.png" alt="Olivia featured Image" />
                        <p class="font-medium text-xl leading-5 text-gray-800 dark:text-white mt-4">Olivia</p>
                        <p class="font-normal text-base leading-6 text-gray-600 dark:text-white">Olivia handles customer relations. She is passionate about helping users make the most out of Pollify.</p>
                    </div>
                    <div class="p-4 pb-6 flex justify-center flex-col items-center">
                        <img class="md:block hidden" src="https://i.ibb.co/Pc6XVVC/Rectangle-120.png" alt="Liam featued Image" />
                        <img class="md:hidden block" src="https://i.ibb.co/C5MMBcs/Rectangle-120.png" alt="Liam featued Image" />
                        <p class="font-medium text-xl leading-5 text-gray-800 dark:text-white mt-4">Liam</p>
                        <p class="font-normal text-base leading-6 text-gray-600 dark:text-white">Liam leads our tech development. He is dedicated to keeping Pollify's systems secure and adding new features to improve user experience.</p>
                    </div>
                    <div class="p-4 pb-6 flex justify-center flex-col items-center">
                        <img class="md:block hidden" src="https://i.ibb.co/7nSJPXQ/Rectangle-121.png" alt="Elijah featured image" />
                        <img class="md:hidden block" src="https://i.ibb.co/ThZBWxH/Rectangle-121.png" alt="Elijah featured image" />
                        <p class="font-medium text-xl leading-5 text-gray-800 dark:text-white mt-4">Elijah</p>
                        <p class="font-normal text-base leading-6 text-gray-600 dark:text-white">Elijah is our creative mind, responsible for designing an intuitive and beautiful interface that makes Pollify easy to use.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php view("partials/footer.view.php"); ?>
