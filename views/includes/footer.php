    <!-- delayed scripts -->

    <script>
        $(function(){
            $("#user-options-container").jui_dropdown({
                launcher_id: 'option-trigger',
                launcher_container_id: 'user-options',
                menu_id: 'menu',
                launcherUIShowText: false,
                launcherUISecondaryIconClass: 'ui-icon-gear',
                menuClass: 'menu4',
                containerClass: 'container4',
                my_position: 'top',
                at_position: 'right bottom',
                onSelect: function(event, data) {
                    $("#result").text('index: ' + data.index + ' (id: ' + data.id + ')');
                }
            }).hover(function(){
                    $("#user-options-container").jui_dropdown({
                        launchOnMouseEnter: true
                    });
                });




        });
    </script>
    </body>
</html>