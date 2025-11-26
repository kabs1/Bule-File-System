@php
$containerFooter =
isset($configData['contentLayout']) && $configData['contentLayout'] === 'compact'
? 'container-xxl'
: 'container-fluid';
@endphp

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
  <div class="{{ $containerFooter }}">
    <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
      <div class="mb-2 mb-md-0">
        &#169;
        <script>
        document.write(new Date().getFullYear())
        </script>
        Blue File | All rights Reserved
      </div>
      <div class="d-none d-lg-inline-block">
        <span id="datetime-counter"></span>
        <script>
          function updateDateTime() {
            const now = new Date();
            const year = now.getFullYear();
            const month = now.toLocaleString('en-us', { month: 'short' });
            const weekday = now.toLocaleString('en-us', { weekday: 'short' });
            const day = now.getDate();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            document.getElementById('datetime-counter').innerText = `${year}/${month}/${weekday} ${day} - ${hours}:${minutes}:${seconds}`;
          }
          setInterval(updateDateTime, 1000);
          updateDateTime(); // Initial call to display immediately
        </script>
      </div>
    </div>
  </div>
</footer>
<!--/ Footer-->
