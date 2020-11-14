import React, { Component } from 'react';
import { Platform, StyleSheet, Text, View, SafeAreaView, ScrollView, Dimensions, Image } from 'react-native';
import { Button } from 'react-native';
import { createAppContainer } from 'react-navigation';
import { Icon } from 'native-base';
import HomePage from './HomePage';
import SettingsPage from './SettingsPage';
import NotificationPage from './Notifications';
import NewsPage from './News';
import Main from './Main';
import { DrawerItems, createDrawerNavigator } from 'react-navigation-drawer';

const { width } = Dimensions.get("window");

const CustomDrawerNavigation = ( props ) => {
  return (
    <SafeAreaView style={{ flex: 1 }}>
      <View style={{ height: 250, backgroundColor: '#d2d2d2', opacity: 0.9 }}>
        <View style={{ height: 200, backgroundColor: 'Green', alignItems: 'center', justifyContent: 'center' }}>
          <Image source={require('../../assets/no-image.png')} style={{ height: 150, width: 150, borderRadius: 60 }} />
        </View>
        <View style={{ height: 50, backgroundColor: 'Green', alignItems: 'center', justifyContent: 'center' }}>
          <Text>Nasys</Text>
        </View>
      </View>
      <ScrollView>
        <DrawerItems {...props} />
      </ScrollView>
      <View style={{ alignItems: "center", bottom: 20 }}>
        <View style={{ flexDirection: 'row' }}>
          <View style={{ flexDirection: 'column', marginRight: 15 }}>
            <Icon name="flask" style={{ fontSize: 24, display: 'none' }} onPress={() => console.log("flask")} />
          </View>
          <View style={{ flexDirection: 'column' }}>
            <Icon name="call" style={{ fontSize: 24, display: 'none' }} onPress={() => console.log("Call")} />
             <Button
                onPress={() => props.navigation.navigate('Login') }
                title='Logout'
                color="#CCC"
                backgroundColor='#CCC'
                accessibilityLabel="Logout"
             />
          </View>
        </View>
      </View>
    </SafeAreaView>
  );
}

const Drawer = createDrawerNavigator({
  Home: {
    screen: HomePage,
    navigationOptions: {
      title: 'Welcome you went Homepage'
    }
  },
  Settings: {
    screen: SettingsPage,
    navigationOptions: {
      title: 'Settings'
    }
  },
  Notifications: {
    screen: NotificationPage,
    navigationOptions: {
      title: 'Notifications'
    }
  },
  Main: {
      screen: Main,
      navigationOptions: {
        title: 'Main'
      }
    },
  News: {
    screen: NewsPage,
    navigationOptions: {
      title: 'News'
    }
  }
},
  {
    drawerPosition: 'left',
    contentComponent: CustomDrawerNavigation,
    drawerOpenRoute: 'DrawerOpen',
    drawerCloseRoute: 'DrawerClose',
    drawerToggleRoute: 'DrawerToggle',
    drawerWidth: (width / 3) * 2
  });

const HomeScreen = createAppContainer(Drawer);

export default HomeScreen;


//import * as React from 'react';
//import { View } from 'react-native';
//import { Button, Menu, Divider, Provider } from 'react-native-paper';
//
//const HomeScreen = () => {
//  const [visible, setVisible] = React.useState(false);
//
//  const openMenu = () => setVisible(true);
//
//  const closeMenu = () => setVisible(false);
//
//  return (
//    <Provider>
//      <View
//        style={{
//          paddingTop: 50,
//          flexDirection: 'row',
//          justifyContent: 'center',
//        }}>
//        <Menu
//          visible={visible}
//          onDismiss={closeMenu}
//          anchor={<Button onPress={openMenu}>Show menu</Button>}>
//          <Menu.Item onPress={() => {}} title="Item 1" />
//          <Menu.Item onPress={() => {}} title="Item 2" />
//          <Divider />
//          <Menu.Item onPress={() => {}} title="Item 3" />
//        </Menu>
//      </View>
//    </Provider>
//  );
//};
//
//export default HomeScreen;



// menu material

//import React from 'react';
//
//import { View, Text } from 'react-native';
//import Menu, { MenuItem, MenuDivider } from 'react-native-material-menu';
//
//class HomeScreen extends React.PureComponent {
//  _menu = null;
//
//  setMenuRef = ref => {
//    this._menu = ref;
//  };
//
//  hideMenu = () => {
//    this._menu.hide();
//  };
//
//  showMenu = () => {
//    this._menu.show();
//  };
//
//  render() {
//    return (
//      <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
//        <Menu
//          ref={this.setMenuRef}
//          button={<Text onPress={this.showMenu}>Show menu</Text>}
//        >
//          <MenuItem onPress={this.hideMenu}>Menu item 1</MenuItem>
//          <MenuItem onPress={this.hideMenu}>Menu item 2</MenuItem>
//          <MenuItem onPress={this.hideMenu} disabled>
//            Menu item 3
//          </MenuItem>
//          <MenuDivider />
//          <MenuItem onPress={this.hideMenu}>Menu item 4</MenuItem>
//        </Menu>
//      </View>
//    );
//  }
//}
//
//export default HomeScreen;


//import React, { useRef } from 'react';
//
//import { View, Text, StyleSheet } from 'react-native';
//import Menu, { MenuItem, MenuDivider } from 'react-native-material-menu';
//function HomeScreen() {
//  const menu = useRef();
//
//  const hideMenu = () => menu.current.hide();
//
//  const showMenu = () => menu.current.show();
//
//  return (
//    <View style={styles.container}>
//      <Menu ref={menu} button={<Text onPress={showMenu}>Show menu</Text>}>
//        <MenuItem onPress={hideMenu}>Menu item 1</MenuItem>
//        <MenuItem onPress={hideMenu}>Menu item 2</MenuItem>
//        <MenuItem onPress={hideMenu} disabled>
//          Menu item 3
//        </MenuItem>
//        <MenuDivider />
//        <MenuItem onPress={hideMenu}>Menu item 4</MenuItem>
//      </Menu>
//    </View>
//  );
//}
//
//const styles = StyleSheet.create({
//  container: {
//    flex: 1,
//    alignItems: 'center',
//    justifyContent: 'center',
//  },
//});
//
//export default HomeScreen;





//import React from 'react';
//import { Text } from 'react-native';
//import {
//  Menu,
//  MenuProvider,
//  MenuOptions,
//  MenuOption,
//  MenuTrigger,
//} from 'react-native-popup-menu';
//
//const HomeScreen = () => (
//  <MenuProvider style={{flexDirection: 'column', padding: 30}}>
//    <Text>Hello world!</Text>
//    <Menu onSelect={value => alert(`Selected number: ${value}`)}>
//      <MenuTrigger text='Select option' />
//      <MenuOptions>
//        <MenuOption value={1} text='One' />
//        <MenuOption value={2}>
//          <Text style={{color: 'red'}}>Two</Text>
//        </MenuOption>
//        <MenuOption value={3} disabled={true} text='Three' />
//      </MenuOptions>
//    </Menu>
//  </MenuProvider>
//);
//
//export default HomeScreen;