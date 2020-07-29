package com.jetnews.concierge.adapter_view

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.jetnews.concierge.R

class AdapterData(val listData: ArrayList<String>) : RecyclerView.Adapter<AdapterData.ViewHolderData>() {


    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolderData {

        val v = LayoutInflater.from(parent.context)
                .inflate(R.layout.item_person_list, parent, false)

        return ViewHolderData(v)
    }

    override fun onBindViewHolder(holder: ViewHolderData, position: Int) {

        holder.assignData(listData[position]);

    }

    override fun getItemCount(): Int {
        return listData.size
    }

    class ViewHolderData(itemView: View) : RecyclerView.ViewHolder(itemView) {

        val textView: TextView

        init {
            textView = itemView.findViewById(R.id.idDato)
        }

        fun assignData(data: String) {
            textView.text = data
        }

    }
}