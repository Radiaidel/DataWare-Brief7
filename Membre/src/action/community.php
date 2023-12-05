<?php 
include("../../../includes/config/connection.php");
include '../../template/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Community Page</title>
</head>

<body class="bg-gray-200 p-4">

    <div class="flex flex-col lg:flex-row">
        <!-- Left Side - List of Questions -->
        <div class="w-full lg:w-2/4 pr-4 mb-4 lg:mb-0">
        <div class="flex items-center space-x-3 mb-4 my-5">
                <!-- Filter Buttons -->
                <div>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-full">All questions</button>
                </div>
                <div>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded-full">My questions</button>
                </div>

                <!-- Search Bar -->
                <div class="flex-1">
                    <form action="">
                        <input type="text" placeholder="Search questions..."
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500">
                    </form>
                </div>
            </div>
            <?php
            $sql = "SELECT * FROM question";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="max-w-xl bg-white p-8 rounded-md shadow-md my-5 cursor-pointer hover:shadow-xl">

                        <div class="flex items-center text-gray-600 mb-4">
                            <div class="flex-shrink-0">
                                <svg width="30px" height="30px" viewBox="0 0 20 20" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#17d924"
                                    stroke="#17d924">
                                    <!-- Your SVG content here -->
                                </svg>
                            </div>
                            <div class="ml-2">
                                <p class="text-sm">Posted by
                                    <?php echo $row['user_id']; ?>
                                </p>
                                <p class="text-xs">Posted on
                                    <?php echo $row['created_at']; ?>
                                </p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <!-- <h2 class="text-xl font-semibold mb-2"><?php echo $row['titre_question']; ?></h2> -->
                            <p class="text-gray-700">
                                <?php echo $row['question_text']; ?>
                            </p>
                        </div>

                        <div class="mb-4">
                            <span class="inline-block bg-blue-200 text-blue-800 py-1 px-2 rounded mr-2">#web</span>
                            <span class="inline-block bg-green-200 text-green-800 py-1 px-2 rounded mr-2">#product</span>
                            <span class="inline-block bg-yellow-200 text-yellow-800 py-1 px-2 rounded mr-2">#html</span>
                            <span class="inline-block bg-yellow-200 text-yellow-800 py-1 px-2 rounded mr-2">#js</span>
                        </div>

                        <div class="flex items-center space-x-4">

                            <button class="flex items-center text-gray-600 hover:text-blue-500">
                                <svg fill="#0473c8" width="20px" height="20px" viewBox="0 0 24 24"
                                    id="a11298b2-e15e-46f5-bfd2-69e168954b14" data-name="Livello 1"
                                    xmlns="http://www.w3.org/2000/svg" stroke="#0473c8">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M8,11.47A18.74,18.74,0,0,0,10.69,8.9a18.74,18.74,0,0,0,1.76-2.42A6.42,6.42,0,0,0,13,5.41l1.74-4.57a4.45,4.45,0,0,1,2.83,2A4,4,0,0,1,18,4.77a2.67,2.67,0,0,1-.09.55L16.72,9.05h5.22a2,2,0,0,1,2,1.85,19.32,19.32,0,0,1-.32,5.44,33.83,33.83,0,0,1-1.23,4.34,3.78,3.78,0,0,1-3.58,2.49,25.54,25.54,0,0,1-6.28-.66A45.85,45.85,0,0,1,8,21.26V11.47Z" />
                                        <path
                                            d="M5,9H1a1,1,0,0,0-1,1V22a1,1,0,0,0,1,1H5a1,1,0,0,0,1-1V10A1,1,0,0,0,5,9ZM3,21a1,1,0,1,1,1-1A1,1,0,0,1,3,21Z" />
                                    </g>
                                </svg>
                                <span class="ml-1">
                                    <?php echo $row['likes']; ?>
                                </span>
                            </button>


                            <button class="flex items-center text-gray-600 hover:text-red-500">
                                <svg fill="#0473c8" height="20px" width="20px" version="1.1" id="Layer_1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 512 512" xml:space="preserve" stroke="#0473c8">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                    <g id="SVGRepo_iconCarrier">
                                        <g>
                                            <g>
                                                <g>
                                                    <path
                                                        d="M117.333,10.667h-64C23.936,10.667,0,34.603,0,64v170.667C0,264.064,23.936,288,53.333,288H160 c5.888,0,10.667-4.779,10.667-10.667V64C170.667,34.603,146.731,10.667,117.333,10.667z" />
                                                    <path
                                                        d="M512,208c0-18.496-10.603-34.731-26.347-42.667c3.285-6.549,5.013-13.781,5.013-21.333 c0-18.496-10.603-34.752-26.368-42.688c4.864-9.728,6.293-20.928,3.84-32.043C463.36,47.68,443.051,32,419.819,32H224 c-7.232,0-16.405,1.173-25.771,3.285c-5.739,1.301-9.344,6.976-8.064,12.693C191.403,53.632,192,58.859,192,64v213.333 c0,5.739-1.6,11.264-4.736,16.448c-1.835,3.029-2.048,6.763-0.555,9.984l47.957,103.893v72.32c0,3.243,1.472,6.293,3.989,8.341 c0.683,0.555,16.512,13.013,38.677,13.013c24.683,0,64-39.061,64-85.333c0-29.184-10.453-65.515-16.96-85.333h131.755 c28.715,0,53.141-21.248,55.637-48.341c1.387-15.189-3.669-29.824-13.632-40.725C506.901,232.768,512,220.821,512,208z" />
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                <span class="ml-1">
                                    <?php echo $row['dislikes']; ?>
                                </span>
                            </button>

                            <button class="flex items-center text-gray-600 hover:text-green-500">
                                <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">

                                    <title>comment-1</title>
                                    <desc>Created with Sketch Beta.</desc>
                                    <defs>

                                    </defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                        sketch:type="MSPage">
                                        <g id="Icon-Set" sketch:type="MSLayerGroup"
                                            transform="translate(-100.000000, -255.000000)" fill="#000000">
                                            <path
                                                d="M116,281 C114.832,281 113.704,280.864 112.62,280.633 L107.912,283.463 L107.975,278.824 C104.366,276.654 102,273.066 102,269 C102,262.373 108.268,257 116,257 C123.732,257 130,262.373 130,269 C130,275.628 123.732,281 116,281 L116,281 Z M116,255 C107.164,255 100,261.269 100,269 C100,273.419 102.345,277.354 106,279.919 L106,287 L113.009,282.747 C113.979,282.907 114.977,283 116,283 C124.836,283 132,276.732 132,269 C132,261.269 124.836,255 116,255 L116,255 Z"
                                                id="comment-1" sketch:type="MSShapeGroup">

                                            </path>
                                        </g>
                                    </g>
                                </svg>
                                <span class="ml-1">Respond</span>
                            </button>
                        </div>

                    </div>


                    <?php
                }
            } else {
                echo "Aucune question trouvée.";
            }
            ?>

        </div>

        <!-- Right Side - Display Question and Answers -->
        <div class="w-full lg:w-3/4">
            <div class="bg-white p-4 mb-4 my-5">
                <h2 class="text-xl font-bold mb-2">Question 1</h2>
                <p>Content of Question 1...</p>

                <h3 class="text-lg font-bold mt-4 mb-2">Answers</h3>
                <ul>
                    <li>Answer 1</li>
                    <li>Answer 2</li>
                </ul>
            </div>
        </div>
    </div>

</body>

</html>

<?php
$conn->close();
?>