<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $property->title  }}</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        body {
            margin: 0;
        }

        .main-container {
            display: flex;
            height:100vh;
            align-items: center;
            background: #111;
        }

        .main-container .image-container {
            /* flex: 1; */
            height: 100%;

            position: fixed;
            width: 100%;
        }

        .main-container h1 {
            flex: 1;
            text-align: center;
            color: #fff;
            font-family: "Raleway", sans-serif;
            text-transform: uppercase;
            font-size: 60px;
            font-weight: 800;
            letter-spacing: 10px;
            z-index: 100;
            text-shadow: 2px 16px 16px rgba(0, 0, 0, 0.3);
            pointer-events: none;
        }

    </style>
</head>
<body>
    <div class="main-container">
        <h1>{{ $property->title  }}</h1>

        <div class="image-container"></div>
        <input type="hidden" id="imagepath" value="{{asset('images/property/'.$property->panoromic_image)}}">

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/105/three.min.js" integrity="sha512-uWKImujbh9CwNa8Eey5s8vlHDB4o1HhrVszkympkm5ciYTnUEQv3t4QHU02CUqPtdKTg62FsHo12x63q6u0wmg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('backend/assets/js/panolens.min.js') }}"></script>

    <script>
        const panoramaImage = new PANOLENS.ImagePanorama("{{ asset('images/property/' . $property->panoromic_image) }}");
        const imageContainer = document.querySelector(".image-container");
        const viewer = new PANOLENS.Viewer({
            container: imageContainer
            , autoRotate: true
            , autoRotateSpeed: 0.3
            , controlBar: false
        });
        viewer.add(panoramaImage);
    </script>

</body>
</html>

