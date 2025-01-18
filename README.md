<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## Step 1
    Installation (using brew)
    - PHP 8.4
    - Composer
    - Mysql
    - phpmyadmin
    - VS Code
    - apache server

## Step 2
    Setup Environment
    - install project
    - setup .env file and connect DB
    - create DB in phpmyadmin

## Step 3
    - setup folder structure
    - integrate Admin Template

## Step 4
    - implement Admin Auth
    - Secure Admin route

## Step 5
    - Forgot Password
    - Reset Password (PHPMailer, Mailtrap)

## Step 6
    - Handeling Experied Password reset link

## Step 7
    - Setup User Profile page
    - Edit profile  
    - add sweetalert with livewire

## Step 8
    - crop and update (profile pictute)

## Step 9
    - Implement Secure Password Update Feature

## Step 10
    - Prevent browser back history

## Step 11 
    - Update Admin Social Links section

## Step 12
    - General Settings: Update Site Title, Email, Meta Keywords

## Step 13
    - Change Site Logo

## Step 14
    - Site Favicon

## Step 15
    - Categories Page
    - install laravel slug package (https://github.com/cviebrock/eloquent-sluggable)

## Step 16
    - Add Parent Category
    - convert add cetegory component into livewire
    - add parent category to DB
    - show it from db

## Step 17
    - update parent category

## Step 18
    - Reorder & Sort Parent Categories (like drag and drop the order)
    - need jquery ui (https://jqueryui.com/) and downloard, placed in extra-assets
    - store the order in db.

## Step 19
    - Delete Parent Category

## Step 20
    - Add Category
    - save in db
    - show from db
    - Update Category
    - Reorder category
    - Delete Category

## Step 21
    - multiple pagination links on single page.
    - delete parent category, then the child category will be independent
    - active class in side bar menu.

## Step 22
    - Restrict Certain routes with middleware
    - normal will not able to access category, shop and general

## Step 23
    - Post CRUD (Add Posts)
    - creare new controller to manage new post
    - create route for add, submit post and show all post.
    - create a form to add post
    - Featured Image Preview
    - Active bootstrap.tagsinput for input (add css, js link)
    - Create a Post Model
    - use Sluggable package
    - run migrate command
    - submit form data using ajax 

## step 24
    Resize image (Learn how to create resized images and generate thumbnails automatically from the post's featured image when creating a new post. We use the powerful Laravel Image Intervention package to ensure images are optimized for faster loading and improved user experience.)
    - Create Thumbnail
    - make logic in controller for resize image

## step 25
    Integrate CKEditor 4
    - download ckEditor 4, full package (in public folder)
    - add css and js link (make changes in html add class and id)
    - update ajax script for form data submission
    - Integrating elFinder File Manager with CKEditor (https://github.com/barryvdh/laravel-elfinder)
        - composer require barryvdh/laravel-elfinder
        - php artisan elfinder:publish
        - php artisan vendor:publish --provider='Barryvdh\Elfinder\ElfinderServiceProvider' --tag=config
        - php artisan vendor:publish --provider='Barryvdh\Elfinder\ElfinderServiceProvider' --tag=views

## step 26
    Post CRUD Display Posts
    - add method allPosts() inside the PostController
    - designe the all posts page
    - create a live component of post
    - make changes in view and controller of livewire
    - show data in view page
    - make a relationship inside a post model to help to show author and category

## Step 27
    Build a Real-Time Advanced Search Filter and Sort 
    - make filter designe in view file
    - open user model add post relationship for Author filter
    - open category model add post relationship for category filter
    - define a filter properties in livewire posts.php
    - implement the search functionality for post
    - add search() in post model
    - reload the page still have to remain keyword in search box
    - reset the page when the search value is updated
    - same for author, category, visibility and sort by filter.

## Step 28
    Edit & Update Post with AJAX + Featured Image Update
    - make a route for get and post action
    - provide href in view.
    - add editPost() in PostController