(function() {
    window.Webform = {
        containerId: 'webformContainer',
        show: function (json, theme, callback) {
            const survey = new Survey.Model(json);
            survey.applyTheme(theme);

            survey.onComplete.add(function(sender) {
                callback(JSON.stringify(sender.data));
            });

            $(function() {
                $("#" + Webform.containerId).Survey({ model: survey });
            });
        }
    };
})();
