<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel - Upload and Play Audio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Big+Shoulders+Inline:opsz,wght@10..72,100..900&family=Boldonse&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 font-sans  sm:px-0">


<nav class="bg-zinc-950 fixed w-full md:w-20 h-16 md:h-screen top-0 left-0 flex items-center md:flex-col justify-center md:justify-start px-4 md:px-0 shadow-lg z-50">

    <div class="block md:hidden w-full text-center text-white text-xl font-semibold">
    <i class="ri-file-music-line"></i><h1>Audio Player</h1>
    </div>

    <!-- ✅ Desktop Sidebar -->
    <div class="hidden md:flex flex-col items-center space-y-10 mt-10 w-full">

      <!-- 🎵 Logo -->
      <div class="text-3xl font-bold text-green-400">
        <i class="ri-file-music-line"></i>
      </div>

      <!-- 🌐 Navigation Links -->
      <div class="flex flex-col gap-6 text-3xl text-zinc-400 hover:[&>*]:text-white transition-all duration-200">
        <a href="#" class="hover:text-white"><i class="ri-spotify-line"></i></a>
        <a href="#" class="hover:text-white"><i class="ri-album-line"></i></a>
        <a href="#" class="hover:text-white"><i class="ri-music-ai-line"></i></a>
        <a href="#" class="hover:text-white"><i class="ri-music-line"></i></a>
      </div>
    </div>

</nav>


  <!-- Main Content -->
<main class="hidden md:block pt-5 md:ml-20 p-6">
  <h1 class="text-2xl font-semibold"><i class="ri-music-line"></i>Welcome to your Audio Player</h1>
  <p class="mt-4 text-zinc-400">Here you can manage your playlists, search for songs, and listen to your favorites!</p>
</main>


<!-- Main Container -->
<div class=" p-2  w-full max-w-full sm:max-w-xl sm:mx-auto bg-white px-1 sm:px-6 mt-5 rounded-xl shadow-md ">

    <!-- Header and Mic Controls -->
    <div class="flex flex-wrap justify-between items-center gap-2 mb-4">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800 w-full sm:w-auto text-center sm:text-left">Audio Player</h1>

        <div class="flex gap-2 mx-auto sm:mx-0">
            <button id="recordBtn" class="text-gray-600 hover:text-gray-800 hover:bg-gray-200 p-2 rounded-full shadow-sm" title="Start Recording">
                <i class="fas fa-microphone text-2xl"></i>
            </button>
            <button id="stopBtn" class="hidden text-gray-600 hover:text-gray-800 hover:bg-gray-200 p-2 rounded-full shadow-sm" title="Stop Recording">
                <i class="fas fa-stop text-xl"></i>
            </button>
        </div>
    </div>

    <!-- Live Preview -->
    <div id="livePreviewContainer" class="mb-4"></div>

    <!-- Success Message -->
    @if(session('success'))
        <p class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center text-sm sm:text-base">
            {{ session('success') }}
        </p>
    @endif

    <!-- Upload Form -->
    <form method="POST" action="{{ route('audio.upload') }}" enctype="multipart/form-data" class="space-y-4" id="uploadForm">
        @csrf
        <div class="w-full">
          <input
            type="text"
            name="title"
            placeholder="File Title"
            required
            id="titleInput"
            class="w-full h-10 rounded-lg border border-gray-800 bg-transparent px-3 text-sm text-blue-gray-700 outline-none transition focus:border-2 focus:border-gray-700"
          />
        </div>
 
        
        <input type="file" name="audio" id="audioFileInput" class="hidden" required accept="audio/*" />

        <label for="audioFileInput"
              class="bg-white text-center rounded w-full min-h-[180px] py-4 px-4 flex flex-col items-center justify-center cursor-pointer border-2 border-gray-300 mx-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 mb-4 fill-slate-400" viewBox="0 0 24 24">
                <path d="..." />
                <path d="..." />
            </svg>
            <p class="text-slate-400 font-semibold text-sm">
                Drag & Drop or <span class="text-[#007bff]">Choose audio file</span> to upload
            </p>
            <p class="text-xs text-slate-400 mt-2">Only audio files like MP3, WAV, WEBM are allowed.</p>
        </label>
        <p id="selectedFileName" class="text-sm text-gray-600 mt-2 text-center"></p>
        <button type="submit" class="w-full bg-gray-800 text-white py-2 rounded hover:bg-gray-700 text-sm sm:text-base">
            Upload File
        </button>
    </form>

    <hr class="my-6" />
    <h2 class="text-lg sm:text-xl font-semibold mb-4 text-gray-700 text-center sm:text-left">Uploaded Audio Files:</h2>

    <!-- Audio List -->
    @foreach($audios as $audio)
    <div class="mb-6 p-4 rounded bg-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4">
      <div class="w-full">
        <p class="font-medium text-gray-800 truncate">{{ $audio->title }}</p>
        <audio controls class="w-full mt-2">
          <source src="{{ asset('storage/audios/' . $audio->filename) }}" type="audio/mpeg" />
          Your browser does not support the audio element.
        </audio>
      </div>

      <form action="{{ route('audio.delete', $audio->id) }}" method="POST" class="flex-shrink-0">
        @csrf
        @method('DELETE')
        <button type="submit" title="Delete File" class="text-red-500 hover:text-red-700 transition-colors">
          <i class="ri-delete-bin-6-line text-3xl"></i>
        </button>
      </form>
    </div>

    @endforeach
</div>

<!-- Recorder Script -->
<script>
    let mediaRecorder;
    let audioChunks = [];

    const recordBtn = document.getElementById('recordBtn');
    const stopBtn = document.getElementById('stopBtn');
    const audioInput = document.getElementById('audioFileInput');
    const previewContainer = document.getElementById('livePreviewContainer');
    const titleInput = document.getElementById('titleInput');

    recordBtn.addEventListener('click', async () => {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        mediaRecorder = new MediaRecorder(stream);
        audioChunks = [];

        mediaRecorder.ondataavailable = e => {
            audioChunks.push(e.data);
        };

        mediaRecorder.onstop = () => {
            const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
            const audioURL = URL.createObjectURL(audioBlob);

            const audioFile = new File([audioBlob], "recording.webm", { type: 'audio/webm' });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(audioFile);
            audioInput.files = dataTransfer.files;

            previewContainer.innerHTML = `
                <div class="mb-6 p-4 border-yellow-300 bg-yellow-50 rounded-lg shadow-sm">
                    <p class="text-sm sm:text-base text-yellow-800 font-medium mb-2">
                        🎙️ Live recording created (not uploaded yet) —
                        <span class="font-semibold">Click "Upload File" to save it</span>
                    </p>
                    <audio controls class="w-full rounded overflow-hidden">
                        <source src="${audioURL}" type="audio/webm" />
                        Your browser does not support the audio element.
                    </audio>
                </div>
            `;
            titleInput.value = "Live Recording " + new Date().toLocaleString();
        };

        mediaRecorder.start();
        recordBtn.classList.add('hidden');
        stopBtn.classList.remove('hidden');
    });

    stopBtn.addEventListener('click', () => {
        mediaRecorder.stop();
        recordBtn.classList.remove('hidden');
        stopBtn.classList.add('hidden');
    });

  const audioFileInput = document.getElementById('audioFileInput');
  const fileNameDisplay = document.getElementById('selectedFileName');

  audioFileInput.addEventListener('change', function () {
    if (this.files && this.files[0]) {
      fileNameDisplay.textContent = "🎵 Selected File: " + this.files[0].name;
    } else {
      fileNameDisplay.textContent = "";
    }
  });
</script>

</body>
</html>
