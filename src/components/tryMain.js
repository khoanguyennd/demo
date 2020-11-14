import React, { Component } from 'react';
import { StyleSheet, ScrollView, AsyncStorage } from 'react-native';
//import { Table, TableWrapper, Row } from 'react-native-table-component';
import { DataTable } from 'react-native-paper';
import Cookie from 'react-native-cookie'; //npm install react-native-cookie --save
import { LineChart } from 'react-native-chart-kit' // npm i react-native-chart-kit --save  // npm i react-native-svg --save

import Icon from 'react-native-vector-icons/FontAwesome';
import { View, Text, TextInput, Button, TouchableOpacity, Dimensions } from 'react-native';
import { ActivityIndicator, FlatList } from 'react-native';
import { data } from './define';
const server = data[0];

let { height } = Dimensions.get('window');
let box_count = 3;
let box_height = height / box_count;
// line chart//////////////
const dataChart = {
  labels: ['January', 'February', 'March', 'April', 'May', 'June'],
  datasets: [
                {   data: [ 0, 0, 0, 0, 0, 0 ] ,
                    color: (opacity = 1) => `rgba(91, 177, 217, ${opacity})`, // optional
                    strokeWidth: 3, // optional
                },
                {   data: [ 10, 25, 68, 20, 79, 53 ] ,
                    color: (opacity = 1) => `rgba(253, 209, 0, ${opacity})`, // optional
                    strokeWidth: 3 , // optional
                },
            ],
  legend: ["Rainy Days" , 'weekend'] // optional
}
const screenWidth = Dimensions.get('window').width;
const chartConfig = {
  backgroundGradientFrom: "#1E2923",
  backgroundGradientFromOpacity: 0.8,
  backgroundGradientTo: "#08130D",
  backgroundGradientToOpacity: 0.5,
  color: (opacity = 1) => `rgba(26, 255, 146, ${opacity})`,
  labelColor: (opacity = 1) => `rgba(26, 255, 146, ${opacity})`,
  strokeWidth: 3, // optional, default 3
  barPercentage: 10,
  useShadowColorFromDataset: false,// optional
  decimalPlaces: 0,
};
//////////////////

export default class Main extends Component {
  constructor(props) {
     super(props);
     this.state = {
       dataApi: [],
       isLoading: true,
       searchtext: "",
       username: "",
       session : "aaa"
     };
  }
  componentDidMount() { //auto run function
       // get session
       AsyncStorage.getItem('accountshopping', (err, result) => {
             //console.log(JSON.parse(result).account_ID);
             //this.setState({ session: JSON.parse(result).account_ID });


              fetch(server+'orderApi.html', {
                           method: 'POST',
                           headers: {
                             Accept: 'application/json',
                             'Content-Type': 'application/json',
                           },
                           body: JSON.stringify({
                               account_idx: JSON.parse(result).account_idx,
                               account_ID: JSON.parse(result).account_ID,
                               account_role: JSON.parse(result).account_role,
                               method: ""
                           }),
                         })
                      .then((response) => response.json())
                      .then((responseJson) => {
                          if (responseJson.result) {
                               console.log(responseJson.list_order);
                               this.setState({ dataApi: responseJson.list_order });
                          }
                      })
                      .catch((error) => console.error(error))
                      .finally(() => {
                           this.setState({ isLoading: false });
                      });
       });
       //AsyncStorage.removeItem(SESSION_KEY);



  }

  render() {
     const { navigation } = this.props;
     const searchSubmit = () => {
        fetch(server+'orderApi.html')
           .then((response) => response.json())
           .then((responseJson) => {
               if (responseJson.result) {
                    console.log(responseJson.list_order);
                    this.setState({ dataApi: responseJson.list_order });
               }
           })
           .catch((error) => console.error(error))
           .finally(() => {
                this.setState({ isLoading: false });
           });
     };

    return (
        <ScrollView  style={styles.container}>

                <View style={{width: '100%', borderColor: '#000', borderWidth: 1, borderRadius: 5}}>
                    <View style={{height:50, borderBottom: "#ccc", borderBottomWidth: 1, paddingTop:15}}>
                       <View style={{flex: 1, flexDirection: 'row'}}>
                           <View style={{width: '20%'}} >
                               <Text style={{left: 10}}>T-BRIDGE </Text>
                           </View>
                           <View style={{width: '79%', bottom: 5}} >
                               <TouchableOpacity activeOpacity={0.95}>
                                  <TextInput style={{borderColor: '#ccc', borderWidth: 1}} value={this.state.searchtext}
                                       onChangeText={searchtext =>
                                           this.setState({ searchtext })
                                       }
                                       ref={input => {
                                           this.textInput = input;
                                       }}  placeholder="홍길동 (name)"/>
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
                    <View style= {{  color: '#CCC', margin: 10 }}>
                        <Text style={{fontSize: 16, fontWeight: 'bold', alignItems: 'center' }}>Tình hình bán vé</Text>
                    </View>
                    <View style={{ height: 1, width: '100%', borderRadius: 1, borderWidth: 0.5, borderColor: '#000' }}></View>
                        {this.state.isLoading ? <ActivityIndicator/> : (
                             <FlatList
                                  data={this.state.dataApi}
                                  keyExtractor={({ id }, index) => id}
                                  renderItem={({ item, index }) => (

                                  <View style= {{  color: '#CCC' , height : 150, marginTop: 20 }}>
                                      <View style={{flex: 1, flexDirection: 'row'}}>
                                         <View style={[styles.boxTicket, styles.boxTicket3]}></View>
                                         <View style={[styles.boxTicket5, styles.boxTicket4]}><Text>{item.price}</Text></View>
                                         <View style={[styles.boxTicket5, styles.boxTicket4]}><Text>{item.price}</Text></View>
                                      </View>
                                      <View style={{flex: 1, flexDirection: 'row'}}>
                                          <View style={[styles.boxTicket, styles.boxTicket1]}><Text>Số tiền bán thực</Text></View>
                                          <View style={[styles.boxTicket5, styles.boxTicket2]}><Text>{item.price}</Text></View>
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
                            )}
                            />
                        )}

                    <View style= {{padding: 10, width: '100%', alignItems: 'center', justifyContent: 'center', color: '#CCC'}}>
                       <LineChart
                         data={dataChart}
                         width={screenWidth-20}
                         height={220}
                         chartConfig={chartConfig}
                       />
                    </View>

                    <View style= {{padding: 10, width: '100%', alignItems: 'center', justifyContent: 'center', color: '#CCC'}}>
                       <LineChart
                         data={dataChart}
                         width={screenWidth-20}
                         height={220}
                         chartConfig={chartConfig}
                       />
                    </View>
                     <View style= {{padding: 10, width: '100%', alignItems: 'center', justifyContent: 'center', color: '#CCC'}}>
                                               <TouchableOpacity activeOpacity={0.95} style={styles.button} onPress={() => {navigation.navigate('Order');}} >
                                                   <Text style={styles.text}>Xem toàn bộ đơn hàng > </Text>
                                               </TouchableOpacity>
                                         </View>
                    <View style={{width: '22%',  position: 'absolute', right: 5, top: 10}}>
                        <Icon.Button style={{ backgroundColor: '#DB4437', height: 30}}
                           name='search'
                           onPress={searchSubmit}
                        >
                        </Icon.Button>
                    </View>
                </View>
            </ScrollView >

    );
  }

};

 const styles = StyleSheet.create({
  container: { flex: 1, padding: 5, paddingTop: 30, backgroundColor: '#fff' },
  header: { height: 50, backgroundColor: '#537791' },
  dataWrapper: { marginTop: -1 },
  row: { height: 40, backgroundColor: '#E7E6E1' },
  boxTicket: {
          height: 30,
          width: '40%',
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
          marginTop: 52,
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
          padding: 80
      },
      textContentResult: {
          marginLeft: 8,
          width: '46%',
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
      },
});
