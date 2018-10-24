// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.


// TODO: Refactor this to use updated Points model
window.ewcharts = {

    overallScore: function () {

        let jqxhr = $.getJSON("http://otew.io/api/points/grabPoints")

            .done(function (response) {
                console.log(response);
                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Topping');
                data.addColumn('number', 'Slices');
                data.addRows([
                    ['Blue', response.overallScores.Blue],
                    ['Purple', response.overallScores.Purple],
                    ['Teal', response.overallScores.Teal],
                    ['Red', response.overallScores.Red],
                    ['Grey', response.overallScores.Grey]
                ]);

                // Set chart options
                var options = {
                    'title': 'Points Per Team',
                    'width': 400,
                    'height': 300,
                    'colors': ['blue', 'purple', 'teal', 'red', 'grey']
                };

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('overallScores'));
                chart.draw(data, options);
            });


    }
};