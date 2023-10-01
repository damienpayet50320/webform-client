(function() {
    window.Webform = {
        containerId: 'webformContainer',
        show: function (json, callback) {
            const survey = new Survey.Model(json);

            survey.onComplete.add(function(sender) {
                callback(JSON.stringify(sender.data));
            });

            $(function() {
                $("#" + Webform.containerId).Survey({ model: survey });
            });
        }
    };
})();
