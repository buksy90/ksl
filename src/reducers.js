import { combineReducers } from 'redux'
import { connectRouter } from 'connected-react-router'
import { actionTypes } from "./actions.js";

const initialState = {
    counter: 0
};

function myReducer(state = initialState, action) {
  switch (action.type) {
    case actionTypes.INCREMENT:
      return Object.assign({}, state, {
        counter: state.counter+1
      });
    default:
      return state
  }
}

export default (history) => combineReducers({
  router: connectRouter(history),
  myReducer: myReducer
  //... // rest of your reducers
});