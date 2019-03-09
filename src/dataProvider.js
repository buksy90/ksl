const providers = {
    getNewsList: function() {
        return [
            { id: 1, title: "Title 1", text: "This is text of new's item." },
            { id: 2, title: "Title 2", text: "This is text of new's item." },
            { id: 3, title: "Title 3", text: "This is text of new's item." },
        ];
    },

    getTeamsList: function() {
        return [
            { id: 1, name: "Team 1" },
            { id: 2, name: "Team 2" },
            { id: 3, name: "Team 3" },
            { id: 4, name: "Team 4" },
        ];
    },

    getPlaygroundsList: function() {
        return [
            { id: 1, name: "Playground 1", district: "District 1" },
            { id: 2, name: "Playground 2", district: "District 2" },
            { id: 3, name: "Playground 3", district: "District 3" },
        ];
    }
};

export default providers;