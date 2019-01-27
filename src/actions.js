const actionTypes = {
    "INCREMENT": "INCREMENT"
};

function incrementCounter() {
    return {
        type: actionTypes.INCREMENT
    };
}

export {
    actionTypes,
    incrementCounter
};