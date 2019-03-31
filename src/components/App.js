import React, { Component, Suspense, lazy } from 'react';
import { Route, Switch } from 'react-router-dom'
import { Provider } from 'react-redux'
import { ConnectedRouter } from 'connected-react-router'
import configureStore, { history } from '../configureStore'

import MainMenu from "./MainMenu";

const Home = lazy(() => import('../pages/Home'));
const Schedule = lazy(() => import('../pages/Schedule'));
const AboutUs = lazy(() => import('../pages/AboutUs'));
const PlaygroundList = lazy(() => import('../pages/PlaygroundList'));

const store = configureStore(/* provide initial state if any */)

class App extends Component {
  render() {
    return (
      <Provider store={store}>
      <ConnectedRouter history={history}>
        <div>
          <MainMenu/>

          <Suspense fallback={<div>Loading...</div>}>
            <Switch>
              <Route exact path="/" component={props => <Home {...props}/>}/>
              <Route path="/schedule" component={props => <Schedule {...props}/>}/>
              <Route path="/aboutUs" component={props => <AboutUs {...props}/>}/>
              <Route path="/playground" component={props => <PlaygroundList {...props}/>}/>
            </Switch>
          </Suspense>
        </div>
      </ConnectedRouter>
      </Provider>
    );
  }
}

export default App;
