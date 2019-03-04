import React, { Component } from 'react';
import Playground from '../components/Playground';

export default class PlayGroundList extends Component {
  render(){
    return (
      <div className="container">
          <h1 className="display-4 border-bottom mb-4 mt-5">{this.props.heading}</h1>
          <div className="card" >
                <div className="card-header text-white bg-dark">
                    {this.props.listTitle}
                </div>
                <ul className="list-group list-group-flush">
                    <Playground street="Amurská" province="Nad Jazerom" httpLink="" />  
                    <Playground street="Pajorova" province="Staré mesto" httpLink="" />
                    <Playground street="Bernolákova" province="Západ" httpLink="" />
                    <Playground street="Považská" province="Západ" httpLink="" />
                    <Playground street="Cottbuská" province="KVP" httpLink="" />
                    <Playground street="Hroncova" province="Sever" httpLink="" />
                </ul>
          </div>
      </div>    
    );
  }
}