# 1st Video
==============



# 2nd Video
==============



# 3rd Video
==============



# 4th Video
==============

=> php artisan make:seeder AdminSeeder

        User::create([
            'name'      =>  'Md. Azizur Rahman',
            'email'     =>  'azizur@vshop.com',
            'password'  =>  Hash::make('1234'),
            'isAdmin'   =>  '1'
        ]);
=> php artisan DB:seed AdminSeeder

Same way make for Brand, Category

=> ProductSeeder should be like below
        Product::create([
            'title' => 'AXE DEO AER APOLLO EAW 12X150ML',
            'price' => 290.96,
            'quantity' => 50,
            'category_id' => 1,
            'brand_id' => 1,
            'description' => 'This is a sample product description of AXE Body Spray.',
        ]);

    # google Search for "laravel-sluggable" go to github.com link
       => composer require spatie/laravel-sluggable 

        follow other instructions, model protected fillable set and then run below command
       => php artisan DB:seed ProductSeeder

