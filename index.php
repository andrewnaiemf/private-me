<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <title>Document</title>
</head>

<body>
    <div class="container">
        <form action="man.php" method="post">
            <div class="row">
                <div class="col-md-12">
                    FTXInfotech admin panel Auto generated.
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="m_name_p" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">module pruler name</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="m_name_s" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">module single name</label>
                    </div>
                </div>
            </div>
            <div id="div_'+i+'" class="row">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" name="property_name[]" class="form-control">
                        <label for="floatingInput">property name</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="property_type[]" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                        <option selected>Open this select menu</option>
                        <option value="integer">integer</option>
                        <option value="string">string</option>
                        <option value="double">double</option>
                        <option value="dateTime">dateTime</option>
                        <option value="date">date</option>
                        <option value="float">float</option>
                        <option value="timeTz">timeTz</option>
                        <option value="text">text</option>
                        <option value="boolean">boolean</option>
                        <option value="uuid">uuid</option>
                        <option value="char">char</option>
                        <option value="binary">binary</option>
                        <option value="bigInteger">forginKey</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div id="here"></div>
            </div>
            <div class="row">
                <div id="col-md-2">
                    <button type="button" onclick="addProparty()">Add property</button>
                </div>
            </div>
            <div class="row">
                <div id="col-md-2">
                    <input type="submit" value="submit">
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script>
        var i = 0;

        function remove(i) {
            var element = document.getElementById('div_' + i);
            element.remove();
        }

        function addProparty() {
            i++;
            var element = document.getElementById('here');
            element.insertAdjacentHTML('beforeend',
                '<div id="div_' + i + '" class="row">\
                <div class="col-md-4">\
                <div class="form-floating mb-3">\
                    <input type="text"name="property_name[]" class="form-control">\
                    <label for="floatingInput">property name</label>\
                </div>\
            </div>\
            <div class="col-md-4">\
            <select name="property_type[]" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">\
                <option selected>Open this select menu</option>\
                <option value="integer">integer</option>\
                <option value="string">string</option>\
                <option value="double">double</option>\
                <option value="dateTime">dateTime</option>\
                <option value="date">date</option>\
                <option value="float">float</option>\
                <option value="timeTz">timeTz</option>\
                <option value="text">text</option>\
                <option value="boolean">boolean</option>\
                <option value="uuid">uuid</option>\
                <option value="char">char</option>\
                <option value="binary">binary</option>\
                <option value="bigInteger">forginKey</option>\
            </select>\
            </div>\
            <div class="col-md-4">\
                <div class="form-floating mb-3">\
                    <button onclick="remove(' + i + ')">Remove</button>\
                </div>\
            </div>\
            </div>'
            );
        }
    </script>
</body>

</html>