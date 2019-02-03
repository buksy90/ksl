import React, { Component } from 'react';
import UpcomingMatches from '../components/UpcomingMatches';
import NewsList from '../components/NewsList';

export default class Home extends Component {
  render() {
    return (
        <React.Fragment>
            <UpcomingMatches/>
            <NewsList/>
        </React.Fragment>
    );
  }
}