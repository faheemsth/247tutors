



  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
      // Uncomment the following lines if you want to open the popup manually
      // $("#openBtn").click(function() {
      //   $("#overlay").fadeIn(300);
      //   $("#popup").fadeIn(300);
      // });

      // Open Popup after 10 seconds
      setTimeout(function() {
        $("#overlaytens").fadeIn(300);
        $("#popuptens").fadeIn(300);
      }, 100);

      // Close Popup
      $("#closetens, #overlaytens").click(function() {
        $("#overlaytens").fadeOut(300);
        $("#popuptens").fadeOut(300);
      });
    });
  </script>
