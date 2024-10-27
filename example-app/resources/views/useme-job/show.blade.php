
<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Wpis na useme
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
              <div class="relative">
                  <!-- Copy button -->
                  <button onclick="copyContent()" class="absolute top-2 right-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                      <span id="copyButtonText">Copy</span>
                  </button>
                  <br>
                  <br>
                  <a href="{{ $data->job_url }}">{{ $data->job_url }}</a>
                  <br>
                  @php
                  function extractJobId($url) {
                      if (preg_match('/,(\d+)\//', $url, $matches)) {
                          return $matches[1];
                      }
                      return null;
                  }
                  @endphp
                  
                  <a href="https://useme.com/pl/jobs/{{ extractJobId($data->job_url) }}/post-offer/">https://useme.com/pl/jobs/{{ extractJobId($data->job_url) }}/post-offer/</a>
                  <br>
                  
                  <!-- Content container with ID for copying -->
                  <div id="contentToCopy">
                      @php
                      function decodeUnicodeString($string) {
                          return json_decode('"' . str_replace('"', '\\"', $string) . '"');
                      }
                      @endphp

                      {!! decodeUnicodeString(str_replace('\n', '<br>', substr($data->proposal_generated, 1, -1))) !!}
                  </div>
              </div>
          </div>
      </div>
  </div>

  <script>
      function copyContent() {
          // Get the content
          const content = document.getElementById('contentToCopy').innerText;
          
          // Copy to clipboard
          navigator.clipboard.writeText(content).then(() => {
              // Update button text to show feedback
              const button = document.getElementById('copyButtonText');
              button.textContent = 'Copied!';
              
              // Reset button text after 2 seconds
              setTimeout(() => {
                  button.textContent = 'Copy';
              }, 2000);
          }).catch(err => {
              console.error('Failed to copy text: ', err);
              alert('Failed to copy text. Please try again.');
          });
      }
  </script>
</x-app-layout>