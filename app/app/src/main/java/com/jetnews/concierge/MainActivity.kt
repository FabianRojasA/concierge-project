package com.jetnews.concierge

import android.os.Bundle
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import androidx.compose.frames.commit
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.google.gson.Gson
import com.google.gson.JsonParser
import com.jetnews.concierge.adapter_view.AdapterData
import com.jetnews.concierge.api.ApiAdapter
import com.jetnews.concierge.model.Person
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.GlobalScope
import kotlinx.coroutines.async
import kotlinx.coroutines.launch


class MainActivity : AppCompatActivity() {


    lateinit var personas: ArrayList<Person>
    lateinit var listData: ArrayList<String>
    lateinit var recyclerView: RecyclerView
    lateinit var viewManager: RecyclerView.LayoutManager
    lateinit var viewAdapter: RecyclerView.Adapter<*>


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)



        setContentView(R.layout.persons_list)


        onClick()
    }

    fun updateUi() {


        recyclerView = findViewById<RecyclerView>(R.id.lista_personas)
        recyclerView.setHasFixedSize(true)
        recyclerView.layoutManager = LinearLayoutManager(this)


        val n = personas.size
        listData = ArrayList(n)

        for (i in 0 until n) {
            listData.add(personas[i].toString())
        }

        viewAdapter = AdapterData(listData = listData)


        recyclerView.adapter = viewAdapter


    }

    fun onClick() {
        findViewById<Button>(R.id.btn_get_personas).setOnClickListener {
            GlobalScope.async(Dispatchers.Main) {
                try {
                    val response = ApiAdapter.apiClient.getPersonas()

                    if (response.isSuccessful && response.body() != null) {
                        val data = response.body()!!

                        /*
                    data.message?.let { messageDATA ->
                        findViewById<TextView>(R.id.message_text).text  = messageDATA
                    }*/

                        data.people.let { jsonArray ->
                            if (jsonArray != null) {

                                var cant = jsonArray.size()
                                personas = ArrayList(cant)

                                for (i in 0..cant - 1) {
                                    val jsonObject = jsonArray.get(i)
                                    val mJsonString = jsonObject.toString()
                                    val parser = JsonParser()
                                    val mJson = parser.parse(mJsonString)
                                    val gson = Gson()
                                    val per: Person = gson.fromJson(mJson, Person::class.java)
                                    personas.add(per)
                                }

                                /*
                            for (i in 0..cant -1) {
                                if (i == 0) {
                                    findViewById<TextView>(R.id.message_text).text = personas[i].rut.toString()
                                }else{
                                    findViewById<TextView>(R.id.rest).text = personas[i].rut.toString()
                                }
                            }*/


                            }
                        }
                    } else {
                        Toast.makeText(
                                this@MainActivity,
                                "Error Occurred: ${response.message()}",
                                Toast.LENGTH_LONG
                        ).show()
                    }
                } catch (e: Exception) {
                    // Show API error. This is the error raised by the client.
                    Toast.makeText(
                            this@MainActivity,
                            "Error Occurred: ${e.message}",
                            Toast.LENGTH_LONG
                    ).show()
                }
                updateUi()
            }
        }
    }
}

