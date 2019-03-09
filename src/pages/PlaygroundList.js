import React, { Component } from 'react';
import playgroundListItem from '../components/Playground';

export default class PlayGroundList extends Component {
  render(){
    return (
      <div className="container">
          <h1 className="display-4 border-bottom mb-4 mt-5">Ihriská</h1>
          <div className="card" >
                <div className="card-header text-white bg-dark">
                    Zoznam ihrísk
                </div>
                <ul className="list-group list-group-flush">
                    {playgroundListItem}
                </ul>
          </div>
      </div>    
    );
  }
}