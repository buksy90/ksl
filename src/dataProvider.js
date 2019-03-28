function graphQlRequest(query, variables) {
    var debug = false;
    var host = debug ? "//backend.ksl.localhost:3300/api.php" : "http://new.ksl.sk/api.php";
    return fetch(host, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        mode: "cors",
        cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
        credentials: "omit", // include, *same-origin, omit
        body: JSON.stringify({
            query,
            variables: variables,
        })
    })
    .then(r => r.json())
    .then(response => {
        console.log('data returned:', response); 
        return response.data;
    });
}

const providers = {
    getTeamsStandings: function() {
        var query = '{ teams { id, name } }';
        graphQlRequest(query);
    },

    getNewsList: function() {
        return graphQlRequest('{ news { id, title, text, date } }');
    },

    getMenuTeamsList: function() {
        return graphQlRequest('{ teams { id, name } }');
    },

    getPlaygroundsList: function() {
        return graphQlRequest('{ playgrounds { id, name, address, district } }');
    },

    get2ptShooters: function() {
        return graphQlRequest(`{
            shooters_2pt { 
              standing
              player { display_name },
              team { name },
              games,
              points,
              average
            }
          }`);
    },

    get3ptShooters: function() {
        return graphQlRequest(`{
            shooters_3pt { 
              standing
              player { display_name },
              team { name },
              games,
              points,
              average
            }
          }`);
    },

    getListOfPlayingDates: function() {
        return graphQlRequest(`{matchDays {
            timestamp,
            date
          }}`)
    }
};

export default providers;