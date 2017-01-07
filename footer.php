        </div>
        <!-- jQuery first, then Tether, then Bootstrap JS. -->
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <script src="js/imagesloaded.pkgd.min.js"></script>
        <script src="js/masonry.pkgd.min.js"></script>
        
        <script>
        var $container = $('.masonry-container');
        $container.imagesLoaded( function () {
          $container.masonry({
            columnWidth: '.item',
            itemSelector: '.item'
          });   
        });
        </script>
    </body>
</html>