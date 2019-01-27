import React, { Component } from 'react';
import { connect } from 'react-redux'
import { incrementCounter } from "../actions.js";

const mapStateToProps = (state, ownProps) => {
  return {
    counter: state.myReducer.counter,
    ...ownProps
  };
}

const mapDispatchToProps = dispatch => ({
  incrementCounter: () => {
    return dispatch(incrementCounter());
  }
});

class Home extends Component {
  render() {
    return (
        <div>
            This is home ! <span>{this.props.counter}</span> 
            <button onClick={this.props.incrementCounter}>Increment</button>
        </div>
    );
  }
}

export default connect(mapStateToProps, mapDispatchToProps)(Home);