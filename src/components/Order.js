import React , {PureComponent} from 'react';
import { View, Text, StyleSheet, Dimensions , ScrollView, AsyncStorage} from 'react-native';
import {TabViewAnimated, TabView, SceneMap, TabViewPage, TabBar } from 'react-native-tab-view';
import { Header } from 'react-native-elements';

import { ActivityIndicator, FlatList } from 'react-native';
import {  TextInput, Button } from 'react-native';
import Icon from 'react-native-vector-icons/FontAwesome';
import TabOrderAll from './TabOrderAll';

import { data } from './define';
const server = data[0];

//const initialLayout = { width: Dimensions.get('window').width, height: 1200 };

export default class Order extends PureComponent {

    static navigationOptions = {
           title: '주문관리',
           headerStyle: {
             color: '#DB4437'
           },
           headerTintColor: '#DB4437',
           headerTitleStyle: {
              fontWeight: 'bold',
           },
      };

    constructor(props) {
         super(props);
          var _index= -1;
          console.log(this.props.navigation.getParam('route'));
              if (typeof this.props.navigation.getParam('route') !== 'undefined') {
                   _index=this.props.navigation.getParam('route');
              }
         this.state = {
                  index: _index,
                  routes: [
                              { key: 0, title: '전체' },
                              { key: 1, title: '구매완료' },
                              { key: 2, title: '사용완료' },
                              { key: 3, title: '환불요청' },
                              { key: 4, title: '환불완료' },
                              { key: 5, title: '유효기간지남' }
                  ],

                };

         this.renderScene = this.renderScene.bind();
    }

    renderLabel = ({ route, focused, color }) => {
        return (
          <View>
            <Text
              style={[focused ? styles.activeTabTextColor : styles.label]}
            >
              {route.title}
            </Text>
          </View>
        )
    };

    renderHeader = props => (
        <TabBar
          {...props}
          scrollEnabled
          indicatorStyle={styles.indicator}
          renderLabel={this.renderLabel}
          style={styles.tabbar}
          tabStyle={styles.tab}
          labelStyle={styles.label}
         />
      );

    renderScene = ({ route }) => {
        if (Math.abs(this.state.index - this.state.routes.indexOf(route)) == 0){
            let method='';
            switch (route.key) {
              case 0:
                   method="";
                   break;
              case 1:
                    method="done";
                    break;
              case 2:
                    method="use";
                    break;
              case 3:
                    method="unuse";
                    break;
              case 4:
                    method="refundmoney";
                    break;
              case 5:
                    method="die";
                    break;
              default :
                    return null;

            }

            return <View style={[styles.scene, { backgroundColor: '#ffffff' }]} ><TabOrderAll method={method} searchTextOrder={this.props.navigation.getParam('searchTextOrder') != 'undefined' ? this.props.navigation.getParam('searchTextOrder') : ''} /></View>;
        }
        if(this.state.index==-1)
            this.setState({index: 0 });



    };

    handleIndexChange = (index: number) => {
        this.setState({index, });
    }



  render() {

    return (
       <TabView
           navigationState={this.state}
           renderTabBar={this.renderHeader}
           renderScene={this.renderScene}
           onIndexChange={this.handleIndexChange}
           style={{flex: 1}}
       />
    );
  }

};

 const styles = StyleSheet.create({
 scene: {
     flex: 1,
   },
   navigationBarTitleStyle: {
       backgroundColor: '#DB4437',
       color: '#DB4437'
   },
  text: { textAlign: 'center', fontWeight: '100' },
  dataWrapper: { marginTop: -1 },
  row: { height: 40, backgroundColor: '#E7E6E1' },
    tabbar: {
      height: 40,
      backgroundColor: '#f7f7f7', // mau nen tab
      borderTopWidth: 1,
      borderTopColor: 'red',

    },

    tab: {
      width: 90,
      minHeight: 40 // here
    },
    indicator: {
      backgroundColor: '#DB4437'  // mau gach bottom tab active
    },
    label: {
      color: '#000',  // mau chu text tab
      fontWeight: '400',
      fontSize: 11
    },
   activeTabTextColor: {
    color: '#DB4437',
    fontWeight: '400',
    fontSize: 11
   },
});

