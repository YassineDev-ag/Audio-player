This Laravel-based web application allows users to:

🎤 Record audio directly from the browser using the microphone.

📂 Upload audio files (MP3, WAV, WEBM, and any other supported audio formats).

▶️ Play uploaded audio in-browser.

🗑️ Delete audio files.

🚀 Features

Tailwind CSS UI with a modern, responsive design.

Microphone recording using JavaScript & MediaRecorder API.

Upload preview before submitting.

Laravel routes handle:

Audio upload (POST /audio/upload)

Audio deletion (DELETE /audio/{id})

Audio metadata (title, filename) stored in a MySQL database.

Audio files saved under storage/app/public/audios.

🛠️ How to Use

Run php artisan storage:link to link storage to public/.

Run migrations with php artisan migrate to create MySQL database tables.

Visit the app in your browser.

Record audio with the microphone or manually choose a file to upload.

Uploaded files appear in a list with a playback bar and delete button.