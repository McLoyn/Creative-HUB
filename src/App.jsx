import { useState, useEffect } from "react";
import { QRCodeSVG } from "qrcode.react";
import { pelaku, produk, wisata, modul, SUB } from "./data.js";

const rp = (n) => "Rp" + Math.round(n).toLocaleString("id-ID");
const wa = (no, t) => `https://wa.me/${no}?text=${encodeURIComponent(t)}`;
const P = (id) => pelaku.find((p) => p.id === id);
const NAV = [["etalase", "Etalase"], ["pelaku", "Pelaku"], ["wisata", "Wisata"], ["pesanan", "Pesanan besar"], ["toolkit", "Toolkit"], ["dinas", "Dinas"]];

function Home() {
  return (
    <>
      <section className="hero">
        <h1>Karya Tuban, langsung dari tangan pembuatnya.</h1>
        <p>Tuban Creative Hub mempertemukan pengrajin batik gedog, pengolah siwalan, seniman, dan kreator dengan pembeli, wisatawan, dan instansi.</p>
        <a className="btn" href="#etalase">Lihat etalase</a>
      </section>
      <div className="kain" aria-hidden="true" />
      <h2>Yang sudah bisa dicoba di prototipe ini</h2>
      <ul className="rows">
        {modul.map(([id, t, d]) => (
          <li key={id}><a href={"#" + id}><b>{t}</b><span>{d}</span></a></li>
        ))}
      </ul>
      <p className="muted">Menyusul: manajemen hub fisik, belajar dan mentoring, job board kreator, arsip budaya digital, pendanaan dan CSR, serta kader digital desa.</p>
    </>
  );
}

function Etalase() {
  const [k, setK] = useState("Semua");
  const [s, setS] = useState(null);
  const list = produk.filter((p) => k === "Semua" || p.kat === k);
  const o = s && P(s.pelaku);
  return (
    <>
      <h1>Etalase Tuban</h1>
      <div className="chips">
        {["Semua", SUB[0], SUB[1]].map((c) => (
          <button key={c} aria-pressed={k === c} onClick={() => setK(c)}>{c}</button>
        ))}
      </div>
      <div className="grid">
        {list.map((p) => (
          <button className="card" key={p.id} onClick={() => setS(p)}>
            <b>{p.nama}</b>
            <span>{P(p.pelaku).nama}, {P(p.pelaku).desa}</span>
            <em>{rp(p.harga)}</em>
          </button>
        ))}
      </div>
      {s && (
        <aside className="detail" role="dialog" aria-label={s.nama}>
          <button className="x" onClick={() => setS(null)}>Tutup</button>
          <h2>{s.nama}</h2>
          <p>{s.cerita}</p>
          <p>Dibuat oleh <b>{o.nama}</b>, {o.desa}. Kapasitas {o.kap}.</p>
          <div className="qr">
            <QRCodeSVG value={`https://ekraf-tuban.vercel.app/#produk-${s.id}`} size={92} />
            <div><b>{o.verif ? "Keaslian terverifikasi" : "Menunggu verifikasi"}</b><br />Pindai untuk melihat profil pengrajin dan proses pembuatannya.</div>
          </div>
          <a className="btn" target="_blank" rel="noreferrer" href={wa(o.wa, `Halo ${o.nama}, saya mau pesan ${s.nama} (${rp(s.harga)}) dari Ekraf Tuban.`)}>Pesan lewat WhatsApp</a>
        </aside>
      )}
    </>
  );
}

function Pelaku() {
  const [q, setQ] = useState("");
  const list = pelaku.filter((p) => (p.nama + p.desa + p.sub).toLowerCase().includes(q.toLowerCase()));
  return (
    <>
      <h1>Registri pelaku</h1>
      <input className="search" placeholder="Cari nama, desa, atau subsektor" value={q} onChange={(e) => setQ(e.target.value)} />
      <ul className="rows">
        {list.map((p) => (
          <li key={p.id}>
            <div><b>{p.nama}</b> <span className={"tag " + (p.verif ? "ok" : "")}>{p.verif ? "Terverifikasi" : "Belum diverifikasi"}</span>
              <span>{p.sub}, {p.desa}. {p.bio}</span><span>Kapasitas: {p.kap}</span></div>
          </li>
        ))}
        {!list.length && <li>Tidak ada hasil. Coba kata kunci lain.</li>}
      </ul>
    </>
  );
}

function Wisata() {
  const [f, setF] = useState({ paket: wisata[0].id, nama: "", tgl: "", n: 2 });
  const [ok, setOk] = useState(false);
  const w = wisata.find((x) => x.id === f.paket);
  const set = (k) => (e) => { setOk(false); setF({ ...f, [k]: e.target.value }); };
  const total = w.harga * f.n;
  return (
    <>
      <h1>Wisata kreatif</h1>
      <ul className="rows">
        {wisata.map((x) => (
          <li key={x.id}><div><b>{x.nama}</b><span>{x.lokasi}, {x.durasi}, {rp(x.harga)}/orang. Tuan rumah: {P(x.pelaku).nama}</span></div></li>
        ))}
      </ul>
      <form className="form" onSubmit={(e) => { e.preventDefault(); setOk(true); }}>
        <h2>Pesan paket</h2>
        <label>Paket<select value={f.paket} onChange={set("paket")}>{wisata.map((x) => <option key={x.id} value={x.id}>{x.nama}</option>)}</select></label>
        <label>Nama pemesan<input required value={f.nama} onChange={set("nama")} /></label>
        <label>Tanggal<input required type="date" value={f.tgl} onChange={set("tgl")} /></label>
        <label>Jumlah orang<input type="number" min="1" value={f.n} onChange={set("n")} /></label>
        <button className="btn">Pesan, total {rp(total)}</button>
        {ok && (
          <p className="notice">Permintaan siap dikirim. <a target="_blank" rel="noreferrer" href={wa(P(w.pelaku).wa, `Halo, saya ${f.nama} ingin pesan ${w.nama} pada ${f.tgl} untuk ${f.n} orang.`)}>Kirim ke {P(w.pelaku).nama} lewat WhatsApp</a></p>
        )}
      </form>
    </>
  );
}

function Pesanan() {
  const target = 120;
  const [ik, setIk] = useState([{ id: "sri-rahayu", n: 20 }, { id: "sidomulyo", n: 30 }]);
  const [f, setF] = useState({ id: "sri-rahayu", n: 10 });
  const done = ik.reduce((a, b) => a + b.n, 0);
  const pct = Math.min(100, (done / target) * 100);
  return (
    <>
      <h1>Pesanan besar</h1>
      <div className="brief">
        <b>Permintaan: 120 kain batik gedog untuk seragam instansi</b>
        <span>Tenggat 45 hari. Tidak ada satu pengrajin yang sanggup sendirian, jadi pesanan dibagi.</span>
        <div className="bar" role="progressbar" aria-valuenow={done} aria-valuemax={target}><i style={{ width: pct + "%" }} /></div>
        <span>{done} dari {target} kain dijanjikan{done >= target ? ". Pesanan terpenuhi." : `. Kurang ${target - done} kain.`}</span>
      </div>
      <ul className="rows">
        {ik.map((x, i) => <li key={i}><div><b>{P(x.id).nama}</b><span>{x.n} kain</span></div></li>)}
      </ul>
      <form className="form" onSubmit={(e) => { e.preventDefault(); setIk([...ik, { id: f.id, n: +f.n }]); }}>
        <h2>Ambil bagian</h2>
        <label>Pengrajin<select value={f.id} onChange={(e) => setF({ ...f, id: e.target.value })}>{pelaku.filter((p) => p.sub === SUB[0]).map((p) => <option key={p.id} value={p.id}>{p.nama}</option>)}</select></label>
        <label>Jumlah kain<input type="number" min="1" value={f.n} onChange={(e) => setF({ ...f, n: e.target.value })} /></label>
        <button className="btn">Tambahkan komitmen</button>
      </form>
    </>
  );
}

function Toolkit() {
  const [v, setV] = useState({ bahan: 120000, jam: 40, upah: 8000, overhead: 30000, margin: 30 });
  const set = (k) => (e) => setV({ ...v, [k]: +e.target.value });
  const hpp = v.bahan + v.jam * v.upah + v.overhead;
  const F = (k, l) => <label>{l}<input type="number" min="0" value={v[k]} onChange={set(k)} /></label>;
  return (
    <>
      <h1>Kalkulator HPP</h1>
      <p className="muted">Hitung biaya pokok satu produk, termasuk waktu kerja Anda sendiri.</p>
      <div className="form">
        {F("bahan", "Bahan baku (Rp)")}{F("jam", "Jam kerja")}{F("upah", "Upah per jam (Rp)")}{F("overhead", "Listrik, kemasan, ongkos lain (Rp)")}{F("margin", "Keuntungan (%)")}
      </div>
      <div className="result">
        <span>Biaya pokok (HPP)</span><b>{rp(hpp)}</b>
        <span>Harga jual yang disarankan</span><b>{rp(hpp * (1 + v.margin / 100))}</b>
      </div>
    </>
  );
}

function Dinas() {
  const ver = pelaku.filter((p) => p.verif).length;
  return (
    <>
      <h1>Dasbor Dinas</h1>
      <p className="muted">Data contoh. Angka ini akan diambil dari registri yang hidup.</p>
      <div className="result">
        <span>Pelaku terdaftar</span><b>{pelaku.length}</b>
        <span>Terverifikasi</span><b>{ver} dari {pelaku.length}</b>
        <span>Produk di etalase</span><b>{produk.length}</b>
      </div>
      <h2>Pelaku per subsektor</h2>
      <ul className="rows">
        {SUB.map((s) => {
          const n = pelaku.filter((p) => p.sub === s).length;
          return <li key={s}><div><b>{s}</b><div className="bar"><i style={{ width: (n / pelaku.length) * 100 + "%" }} /></div></div><span>{n}</span></li>;
        })}
      </ul>
    </>
  );
}

const PAGES = { home: Home, etalase: Etalase, pelaku: Pelaku, wisata: Wisata, pesanan: Pesanan, toolkit: Toolkit, dinas: Dinas };

export default function App() {
  const [r, setR] = useState(location.hash.slice(1) || "home");
  useEffect(() => {
    const h = () => { setR(location.hash.slice(1) || "home"); window.scrollTo(0, 0); };
    window.addEventListener("hashchange", h);
    return () => window.removeEventListener("hashchange", h);
  }, []);
  const Page = PAGES[r] || Home;
  return (
    <>
      <p className="banner">Prototipe dengan data contoh. Belum divalidasi di lapangan.</p>
      <header className="top">
        <a href="#home" className="logo">Ekraf Tuban</a>
        <nav>{NAV.map(([id, t]) => <a key={id} href={"#" + id} aria-current={r === id ? "page" : undefined}>{t}</a>)}</nav>
      </header>
      <main><Page /></main>
      <footer>Tuban Creative Hub. Dirancang bersama pelaku ekraf Tuban.</footer>
    </>
  );
}
