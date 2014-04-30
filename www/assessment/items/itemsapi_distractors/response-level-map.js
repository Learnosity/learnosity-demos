function mapResponseLevel (question, response, valid) {

    var out = null;

    if (response && response.value && valid.partial) {

        switch (question.type) {

        case "mcq":
            out = [];
            $.each(question.options, function (index, option) {
                var value_index = response.value.indexOf(option.value);
                if (value_index > -1 && valid.partial.length > value_index) {
                    out.push(valid.partial[value_index]);
                } else {
                    out.push(null);
                }
            });
            break;

        case "association":
        case "clozedropdown":
        case "clozeassociation":
        case "clozeinlinetext":
        case "clozetext":
        case "imageclozeassociation":
        case "imageclozedropdown":
        case "imageclozetext":
        case "choicematrix":
            out = valid.partial;
            break;
        }
    }

    return out;
}
