import React, { useState }  from 'react';
import { View, Text, TextInput, Button, StyleSheet, TouchableOpacity, Dimensions } from 'react-native';
//import FontAwesomeIcon, { SolidIcons, RegularIcons, BrandIcons } from 'react-native-fontawesome';

//import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
//import { faCoffee } from '@fortawesome/free-solid-svg-icons'
//import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'

import Icon from 'react-native-vector-icons/FontAwesome';

let { height } = Dimensions.get('window');
let box_count = 3;
let box_height = height / box_count;

const Main = ({ navigation }) => {
    const [search, onChangeSearch] = useState('');
    const searchSubmit = () => {
        //console.log('search: ', search);
//        fetch('https://reactnative.dev/movies.json')
//              .then((response) => response.json())
//              .then((json) => {
//                console.log(json.movies);
//                this.setState({ data: json.movies });
//              })
//              .catch((error) => console.error(error))
//              .finally(() => {
//                this.setState({ isLoading: false });
//              });
    };


   //    static navigationOptions = {
   //        title: 'T-BRIDGE',
   //        headerStyle: {
   //          //backgroundColor: '#DB4437',
   //           borderColor: '#3b5998', borderWidth: 1
   //        },
   //        headerTintColor: '#3b5998',
   //        headerTitleStyle: {
   //          fontWeight: 'bold',
   //        },
   //        headerRight: (
   //          <View style={{width: '100%', bottom: 5, right:10}} >
   //             <View style={{width: '100%'}}>
   //                 <TouchableOpacity activeOpacity={0.95}>
   //                    <TextInput style={{borderColor: '#3b5998', borderWidth: 1, width: 200}}
   //                         placeholder="홍길동 (name)"/>
   //                 </TouchableOpacity>
   //             </View>
   //             <View style={{  position: 'absolute', right:2}}>
   //                <Icon.Button style={{ backgroundColor: '#3b5998', height: 30, width: 80, zIndex:20}}
   //                    name='search'
   //                    onPress={() => {alert(1);}}
   //                 >
   //                       Search
   //                 </Icon.Button>
   //             </View>
   //          </View>
   //        ),
   //    };


  return (
    <View style={styles.container}>
        <View style={{width: '99%', left: 2, borderColor: '#000', borderWidth: 1, borderRadius: 5}}>
            <View style={{height:50, borderBottom: "#ccc", borderBottomWidth: 1, paddingTop:15}}>
               <View style={{flex: 1, flexDirection: 'row'}}>
                   <View style={{width: '20%'}} >
                       <Text style={{left: 10}}>T-BRIDGE </Text>
                   </View>
                   <View style={{width: '79%', bottom: 5}} >
                       <TouchableOpacity activeOpacity={0.95}>
                          <TextInput style={{borderColor: '#ccc', borderWidth: 1}} onChangeText={(text) => onChangeSearch(text)} value={search} placeholder="홍길동 (name)"/>
                       </TouchableOpacity>
                   </View>

               </View>
            </View>
            <View style= {{ alignItems: 'center', color: '#CCC' , height : 100 , marginTop: 10 }}>
                <View style={{flex: 1, flexDirection: 'row'}}>
                    <View style={styles.textContentResult} >
                        <TouchableOpacity activeOpacity={0.95} onPress={() => {navigation.navigate('Order', { id: 100, title: 'hello' });}} >
                            <Text style={styles.textResult}>60 kết quả</Text>
                            <Text style={{ fontWeight: 'bold'}}> Vé chưa sử dụng</Text>
                            </TouchableOpacity>
                    </View>
                    <View style={styles.textContentResult} >
                        <TouchableOpacity activeOpacity={0.95} onPress={() => {navigation.navigate('Question', { id: 120 });}} >
                            <Text style={styles.textResult}>10 kết quả </Text>
                            <Text style={{ fontWeight: 'bold'  }}> Câu hỏi chưa trả lời</Text>
                        </TouchableOpacity>
                    </View>
                </View>
            </View>
            <View style= {{  color: '#CCC', margin : 5 }}>
                <Text style={{fontSize: 16, fontWeight: 'bold', alignItems: 'center' }}>Tình hình bán vé</Text>
            </View>
            <View style={{ height: 1, width: '100%', borderRadius: 1, borderWidth: 0.5, borderColor: '#000', top: 5 }}></View>
            <View style= {{  color: '#CCC' , height : 150, marginTop: 20 }}>
                <View style={{flex: 1, flexDirection: 'row'}}>
                  <View style={[styles.boxTicket, styles.boxTicket3]}></View>
                  <View style={[styles.boxTicket5, styles.boxTicket4]}></View>
                  <View style={[styles.boxTicket5, styles.boxTicket4]}></View>
              </View>
              <View style={{flex: 1, flexDirection: 'row'}}>
                  <View style={[styles.boxTicket, styles.boxTicket1]}><Text>Số tiền bán thực</Text></View>
                  <View style={[styles.boxTicket5, styles.boxTicket2]}></View>
                  <View style={[styles.boxTicket5, styles.boxTicket2]}></View>
              </View>
              <View style={{flex: 1, flexDirection: 'row'}}>
                <View style={[styles.boxTicket, styles.boxTicket1]}><Text>Số tiền xử lý sử dụng</Text></View>
                <View style={[styles.boxTicket5, styles.boxTicket2]}></View>
                <View style={[styles.boxTicket5, styles.boxTicket2]}></View>
              </View>
              <View style={{flex: 1, flexDirection: 'row'}}>
                <View style={[styles.boxTicket, styles.boxTicket1]}><Text>Số vé bán</Text></View>
                <View style={[styles.boxTicket5, styles.boxTicket2]}></View>
                <View style={[styles.boxTicket5, styles.boxTicket2]}></View>
              </View>
              <View style={{flex: 1, flexDirection: 'row'}}>
                  <View style={[styles.boxTicket, styles.boxTicket1]}><Text>Số vé xử lý sử dụng</Text></View>
                  <View style={[styles.boxTicket5, styles.boxTicket2]}></View>
                  <View style={[styles.boxTicket5, styles.boxTicket2]}></View>
              </View>
            </View>
            <View style= {{  color: '#CCC'}}>
              <TouchableOpacity activeOpacity={0.95} style={styles.button} onPress={() => {navigation.navigate('Order');}} >
                  <Text style={styles.text}>Xem toàn bộ đơn hàng > </Text>
              </TouchableOpacity>
            </View>
            <View style={{width: '20%',  position: 'absolute', right: 5, top: 10}}>
                <Icon.Button style={{ backgroundColor: '#DB4437', height: 30}}
                   name='search'
                      onPress={searchSubmit}
                >
                      Search
                </Icon.Button>
            </View>
        </View>
    </View>
  );
};

const styles = StyleSheet.create({
    container: {
        flex: 1
    },
    boxTicket: {
        height: 30,
        width: '35%',
        paddingTop: 4,
        paddingLeft:2
    },
    boxTicket5: {
        height: 30,
        width: '30%'
    },
    boxTicket1: {
        backgroundColor: '#ccc',
        borderColor: '#000',
        borderWidth: 0.5
    },
    boxTicket2: {
        borderColor: '#000',
        borderWidth: 0.5
    },
    boxTicket3: {
        backgroundColor: '#fff'
    },
    boxTicket4: {
    backgroundColor: '#CCC',
        borderColor: '#000',
        borderWidth: 0.5
    },
    parent: {
        width: 300,
        height: 500,
        backgroundColor: 'red',
        margin: 50,
    },
    button: {
        flexDirection: 'row',
        height: 50,
        alignItems: 'center',
        justifyContent: 'center',
        marginTop: 50,
        color: '#DB4437',
        borderColor: '#DB4437',
        borderWidth: 1,
        borderRadius: 10,
        textDecorationLine: 'none',
        bottom: 30
    },
    text: {
        color: '#DB4437',
        fontSize: 16,
        fontWeight: 'bold',
        padding: 100
    },
    textContentResult: {
        marginLeft: 10,
        width: '48%',
        height: 100,
        borderColor: '#000',
        borderWidth: 0.5,
        alignItems: 'center',
        justifyContent: 'center'
    },
    textResult: {
        fontSize: 18,
        fontWeight: 'bold',
        textDecorationLine: 'underline',
        textDecorationStyle: 'solid',
        textDecorationColor: '#000'
    }
})
export default Main;