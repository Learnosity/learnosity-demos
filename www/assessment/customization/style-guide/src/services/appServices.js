export default  {
    getJson(url) {
        return new Promise((resolve, reject) => {
            fetch(url)
                .then(response => resolve(response.json()));
        });
    }
}
