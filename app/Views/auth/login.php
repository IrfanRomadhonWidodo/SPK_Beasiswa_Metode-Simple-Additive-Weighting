<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Welcome Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'purple-start': '#667eea',
                        'purple-mid': '#764ba2',
                        'purple-end': '#f093fb',
                    }
                }
            }
        }
    </script>
    <style>
        .bg-gradient-welcome {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }
        .bg-gradient-main {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .bg-gradient-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="font-sans h-screen bg-gradient-main flex items-center justify-center overflow-hidden">
    <div class="flex w-[800px] h-[500px] rounded-3xl overflow-hidden shadow-2xl max-md:flex-col max-md:w-[95%] max-md:h-auto max-md:max-w-sm">
        <!-- Welcome Section -->
        <div class="flex-1 bg-gradient-welcome flex flex-col justify-center items-center text-center text-white relative overflow-hidden max-md:p-10 max-md:min-h-[200px]">
            <!-- Decorative circles -->
            <div class="absolute w-[200px] h-[200px] bg-white bg-opacity-10 rounded-full -top-12 -right-12"></div>
            <div class="absolute w-[150px] h-[150px] bg-white bg-opacity-10 rounded-full -bottom-8 -left-8"></div>
            
        <div class="relative z-10">
            <img src="<?= base_url('assets/images/LogoSPK.png') ?>" alt="Logo SPK" class="w-40 mb-4 mx-auto drop-shadow-md">
            <h1 class="text-4xl font-bold mb-3 drop-shadow-lg max-md:text-3xl">Beasiswa KIP</h1>
            <p class="text-base opacity-90 mb-6">Sistem Pendukung Keputusan Method SAW</p>
        </div>

            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-sm opacity-80 max-md:static max-md:transform-none max-md:mt-5">
                www.spkkipsaw.com
            </div>
        </div>

        <!-- Form Section -->
        <div class="flex-1 bg-white px-10 py-10 flex flex-col justify-center max-md:px-8">
            <div class="mb-10">
                <p class="text-lg text-gray-600 mb-1">Hallo !</p>
                <h2 class="text-2xl font-bold text-gray-800 ">Selamat Datang</h2>
            </div>

            <!-- Success Alert -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg mb-5 text-sm">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- Error Alert -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-5 text-sm">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Multiple Errors -->
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-5 text-sm">
                    <ul class="list-none m-0 p-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li class="mb-1"><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/attempt-login') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="mb-5">
                    <label class="block text-sm text-gray-600 mb-2 font-medium" for="email">Email Address</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-sm transition-all duration-300 bg-gray-50 
                                  focus:outline-none focus:border-purple-start focus:bg-white focus:ring-4 focus:ring-purple-start focus:ring-opacity-10" 
                           value="<?= old('email') ?>" 
                           required>
                </div>

                <div class="mb-5">
                    <label class="block text-sm text-gray-600 mb-2 font-medium" for="password">Password</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full px-5 py-3 border-2 border-gray-200 rounded-xl text-sm transition-all duration-300 bg-gray-50 
                                  focus:outline-none focus:border-purple-start focus:bg-white focus:ring-4 focus:ring-purple-start focus:ring-opacity-10" 
                           required>
                </div>

                <div class="flex justify-between items-center mb-8">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="remember" 
                               name="remember" 
                               value="1" 
                               class="mr-2 transform scale-110">
                        <label for="remember" class="text-sm text-gray-600">Remember</label>
                    </div>
                    <a href="#" class="text-sm text-purple-start font-medium hover:underline">Forgot Password ?</a>
                </div>

                <button type="submit" 
                        class="w-full py-3 bg-gradient-btn text-white border-none rounded-xl text-sm font-semibold cursor-pointer 
                               transition-all duration-300 mb-4 hover:-translate-y-1 hover:shadow-xl hover:shadow-purple-start/40">
                    SUBMIT
                </button>
            </form>

            <div class="text-center text-sm text-gray-600">
                Don't have an account? 
                <a href="<?= base_url('auth/register') ?>" class="text-purple-start font-semibold hover:underline">Create Account</a>
            </div>
        </div>
    </div>
</body>
</html>